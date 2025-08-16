<?php
// petualangan_cli.php
// Game petualangan berbasis teks (CLI) - PHP native
// Simpan & jalankan: php petualangan_cli.php

// ----------------------
// Helper : ANSI warna
// ----------------------
$C = (object)[
    'reset' => "\033[0m",
    'bold' => "\033[1m",
    'red' => "\033[1;31m",
    'green' => "\033[1;32m",
    'yellow' => "\033[1;33m",
    'blue' => "\033[1;34m",
    'magenta' => "\033[1;35m",
    'cyan' => "\033[1;36m",
    'gray' => "\033[0;37m",
];

// Jika terminal tidak mendukung ANSI, Anda bisa disable dengan set false
$USE_COLOR = true;
function color($text, $col) {
    global $USE_COLOR, $C;
    if (!$USE_COLOR) return $text;
    return $col . $text . $C->reset;
}

// ----------------------
// Utility input
// ----------------------
function ask($prompt = "> ") {
    echo $prompt;
    $line = fgets(STDIN);
    if ($line === false) return '';
    return trim($line);
}

// ----------------------
// Game state & data
// ----------------------
$world = [
    'lokasi_awal' => 'desa',
    'map' => [
        'desa' => [
            'nama' => 'Desa Sunyi',
            'desc' => 'Sebuah desa kecil dengan beberapa rumah dan sumur tua.',
            'koneksi' => ['hutan','gunung'],
        ],
        'hutan' => [
            'nama' => 'Hutan Gelap',
            'desc' => 'Pepohonan tinggi, banyak jalan setapak. Ada kemungkinan bertemu monster.',
            'koneksi' => ['desa','gua'],
        ],
        'gunung' => [
            'nama' => 'Pegunungan Batu',
            'desc' => 'Jalur berliku. Angin dingin menusuk.',
            'koneksi' => ['desa'],
        ],
        'gua' => [
            'nama' => 'Gua Misterius',
            'desc' => 'Gua sempit dengan cahaya redup. Katanya ada harta di dalamnya.',
            'koneksi' => ['hutan'],
        ],
    ],
    'monsters' => [
        'serigala' => ['nama'=>'Serigala Liar','hp'=>30,'atk'=>8,'drop'=>'taring'],
        'goblin' => ['nama'=>'Goblin','hp'=>20,'atk'=>6,'drop'=>'koin'],
        'naga_kecil' => ['nama'=>'Naga Kecil','hp'=>60,'atk'=>12,'drop'=>'sisik_naga'],
    ],
    'quests' => [
        'harta' => [
            'title' => 'Mencari Harta di Goa',
            'desc' => 'Pergilah ke gua dan ambil "Harta Karun".',
            'target_location' => 'gua',
            'reward' => ['koin'=>50,'xp'=>30],
            'done' => false,
        ],
    ],
];

$state = [
    'player' => [
        'nama' => 'Pemain',
        'lokasi' => $world['lokasi_awal'],
        'hp' => 100,
        'max_hp' => 100,
        'atk' => 10,
        'xp' => 0,
        'level' => 1,
    ],
    'inventory' => [],
    'time' => 0,
];

// ----------------------
// Save / Load
// ----------------------
function save_game($filename = 'save_game.json') {
    global $state;
    $data = json_encode($state, JSON_PRETTY_PRINT);
    if (file_put_contents($filename, $data) !== false) {
        echo color("Game tersimpan ke $filename\n", color_code('green'));
    } else {
        echo color("Gagal menyimpan game.\n", color_code('red'));
    }
}
function load_game($filename = 'save_game.json') {
    global $state;
    if (!file_exists($filename)) {
        echo color("File save tidak ditemukan.\n", color_code('yellow'));
        return false;
    }
    $json = file_get_contents($filename);
    $data = json_decode($json, true);
    if ($data === null) {
        echo color("File save rusak.\n", color_code('red'));
        return false;
    }
    $state = $data;
    echo color("Save berhasil dimuat dari $filename\n", color_code('green'));
    return true;
}

// color_code helper for compatibility inside functions
function color_code($name) {
    global $C;
    return $C->$name ?? $C->reset;
}

// ----------------------
// Gameplay helpers
// ----------------------
function show_status() {
    global $state;
    $p = $state['player'];
    echo color("=== STATUS ===\n", color_code('bold'));
    echo "Nama : " . $p['nama'] . "\n";
    echo "Lokasi : " . $p['lokasi'] . "\n";
    echo "HP : {$p['hp']}/{$p['max_hp']}\n";
    echo "Level : {$p['level']} (XP: {$p['xp']})\n";
    echo "Inventory: " . (empty($state['inventory']) ? '-' : implode(', ', array_map(function($k,$v){return "$k(x$v)";}, array_keys($state['inventory']), $state['inventory']))) . "\n";
}

function add_item($item, $qty=1) {
    global $state;
    if (isset($state['inventory'][$item])) $state['inventory'][$item] += $qty;
    else $state['inventory'][$item] = $qty;
    echo color("Dapat: $item x$qty\n", color_code('yellow'));
}

function remove_item($item, $qty=1) {
    global $state;
    if (!isset($state['inventory'][$item])) return false;
    $state['inventory'][$item] -= $qty;
    if ($state['inventory'][$item] <= 0) unset($state['inventory'][$item]);
    return true;
}

function gain_xp($amount) {
    global $state;
    $state['player']['xp'] += $amount;
    echo color("Mendapat $amount XP\n", color_code('cyan'));
    // level up sederhana: tiap 100 xp level naik
    while ($state['player']['xp'] >= 100) {
        $state['player']['xp'] -= 100;
        $state['player']['level'] += 1;
        $state['player']['max_hp'] += 10;
        $state['player']['atk'] += 2;
        $state['player']['hp'] = $state['player']['max_hp'];
        echo color(">>> LEVEL UP! Sekarang level {$state['player']['level']}\n", color_code('magenta'));
    }
}

// ----------------------
// Encounter / Combat
// ----------------------
function random_encounter() {
    global $world, $state;
    $loc = $state['player']['lokasi'];
    // peluang encounter berbeda per lokasi
    $chance = 0;
    if ($loc == 'hutan') $chance = 50; // 50%
    elseif ($loc == 'gua') $chance = 70;
    elseif ($loc == 'gunung') $chance = 20;
    else $chance = 5;
    $roll = rand(1,100);
    if ($roll <= $chance) {
        // pilih monster random
        $mons_keys = array_keys($world['monsters']);
        $key = $mons_keys[array_rand($mons_keys)];
        $monster = $world['monsters'][$key];
        // adjust monster by chance location (simple)
        combat($monster, $key);
    }
}

function combat($monster, $monster_key) {
    global $state, $world;
    echo color("! Kamu bertemu monster: {$monster['nama']} (HP: {$monster['hp']}, ATK: {$monster['atk']})\n", color_code('red'));
    $mhp = $monster['hp'];
    while ($mhp > 0 && $state['player']['hp'] > 0) {
        echo "[attack] serang | [run] lari | [status] lihat status\n";
        $cmd = ask("> ");
        if ($cmd === 'attack' || $cmd === 'serang') {
            $damage = max(1, rand(1, $state['player']['atk']));
            $mhp -= $damage;
            echo color("Kamu menyerang dan memberi $damage damage.\n", color_code('green'));
            if ($mhp <= 0) {
                echo color("Kamu mengalahkan {$monster['nama']}!\n", color_code('yellow'));
                // drop
                if (!empty($monster['drop'])) {
                    add_item($monster['drop'], 1);
                }
                gain_xp(20);
                return;
            }
            // monster serang balik
            $md = max(1, rand(1, $monster['atk']));
            $state['player']['hp'] -= $md;
            echo color("Monster menyerang balik dan memberi $md damage. HP sekarang: {$state['player']['hp']}\n", color_code('red'));
            if ($state['player']['hp'] <= 0) {
                echo color("Kamu tewas...\n", color_code('red'));
                echo color("Game Over. Kamu bisa load save terakhir atau mulai lagi.\n", color_code('yellow'));
                exit(0);
            }
        } elseif ($cmd === 'run' || $cmd === 'lari') {
            $chance = rand(1,100);
            if ($chance <= 60) {
                echo color("Berhasil melarikan diri!\n", color_code('green'));
                return;
            } else {
                echo color("Gagal lari! Monster menyerang.\n", color_code('red'));
                $md = max(1, rand(1, $monster['atk']));
                $state['player']['hp'] -= $md;
                echo color("Kena $md damage. HP: {$state['player']['hp']}\n", color_code('red'));
                if ($state['player']['hp'] <= 0) {
                    echo color("Kamu tewas...\n", color_code('red'));
                    exit(0);
                }
            }
        } elseif ($cmd === 'status' || $cmd === 'stat') {
            show_status();
        } else {
            echo "Perintah tidak dikenali.\n";
        }
    }
}

// ----------------------
// Actions: move, look, inventory, use
// ----------------------
function look_around() {
    global $world, $state;
    $loc = $state['player']['lokasi'];
    $info = $world['map'][$loc];
    echo color("== " . $info['nama'] . " ==\n", color_code('bold'));
    echo $info['desc'] . "\n";
    echo "Terdapat jalan ke: " . implode(", ", $info['koneksi']) . "\n";
}

function move_to($to) {
    global $world, $state;
    $loc = $state['player']['lokasi'];
    if (!isset($world['map'][$to])) {
        echo color("Lokasi '$to' tidak dikenal.\n", color_code('yellow'));
        return;
    }
    if (!in_array($to, $world['map'][$loc]['koneksi'])) {
        echo color("Tidak ada jalan langsung ke $to dari $loc.\n", color_code('yellow'));
        return;
    }
    $state['player']['lokasi'] = $to;
    $state['time'] += 1;
    echo color("Kamu bergerak ke $to.\n", color_code('cyan'));
    // event on arrival
    if ($to == 'gua') {
        // small scripted event: jika belum ambil harta, dapat harta
        if (!isset($state['inventory']['harta_karun'])) {
            echo color("Di dalam gua kamu menemukan sebuah peti... Kamu mendapat Harta Karun!\n", color_code('yellow'));
            add_item('harta_karun', 1);
            gain_xp(30);
            // menandai quest selesai jika quest aktif
        } else {
            echo "Gua tampak sunyi.\n";
        }
    }
    // random encounter setelah pindah
    random_encounter();
}

// ----------------------
// Quest check
// ----------------------
function check_quests() {
    global $world, $state;
    foreach ($world['quests'] as $key => $q) {
        if ($q['done']) continue;
        // jika target location dan item ditemukan -> selesai
        if (isset($state['inventory']['harta_karun']) && $q['target_location'] == 'gua') {
            echo color("Quest selesai: {$q['title']}!\n", color_code('green'));
            // beri reward
            foreach ($q['reward'] as $it => $val) {
                if ($it == 'xp') gain_xp($val);
                else add_item($it, $val);
            }
            $world['quests'][$key]['done'] = true;
        }
    }
}

// ----------------------
// Command loop
// ----------------------
function show_help() {
    echo color("Perintah: ", color_code('bold')) . "\n";
    echo "- look / lihat      : melihat sekitar\n";
    echo "- go <lokasi>       : pindah lokasi (contoh: go hutan)\n";
    echo "- status / stat     : lihat status\n";
    echo "- inv / inventory   : lihat inventori\n";
    echo "- use <item>        : pakai item (contoh: use koin)\n";
    echo "- save              : simpan game\n";
    echo "- load              : muat save\n";
    echo "- help              : bantuan\n";
    echo "- exit / quit       : keluar game\n";
}

function main_loop() {
    global $state;
    echo color("=== SELAMAT DATANG DI PETUALANGAN CLI ===\n", color_code('bold'));
    echo "Ketik 'help' untuk daftar perintah.\n";
    while (true) {
        echo "\n[" . $state['player']['lokasi'] . "] ";
        $input = ask("> ");
        if ($input === '') continue;
        $parts = explode(' ', $input);
        $cmd = strtolower($parts[0]);
        $arg = isset($parts[1]) ? strtolower($parts[1]) : null;

        switch ($cmd) {
            case 'help':
                show_help();
                break;
            case 'look':
            case 'lihat':
                look_around();
                break;
            case 'go':
            case 'ke':
                if (!$arg) { echo "Ke mana?\n"; break; }
                move_to($arg);
                check_quests();
                break;
            case 'status':
            case 'stat':
                show_status();
                break;
            case 'inv':
            case 'inventory':
                global $state;
                echo color("== INVENTORY ==\n", color_code('bold'));
                if (empty($state['inventory'])) {
                    echo "(kosong)\n";
                } else {
                    foreach ($state['inventory'] as $item => $qty) {
                        echo "- $item x$qty\n";
                    }
                }
                break;
            case 'use':
                if (!$arg) { echo "Use apa?\n"; break; }
                // contoh: use koin -> beli sesuatu, atau use taring -> crafting
                if ($arg == 'koin') {
                    if (isset($state['inventory']['koin']) && $state['inventory']['koin'] > 0) {
                        remove_item('koin', 1);
                        echo "Kamu menukar 1 koin menjadi 5 HP.\n";
                        $state['player']['hp'] = min($state['player']['max_hp'], $state['player']['hp'] + 5);
                    } else echo "Tidak punya koin.\n";
                } elseif ($arg == 'taring') {
                    if (isset($state['inventory']['taring'])) {
                        echo "Kamu membuat pisau sederhana dari taring.\n";
                        remove_item('taring',1);
                        add_item('pisau',1);
                    } else echo "Tidak punya taring.\n";
                } elseif ($arg == 'harta_karun') {
                    echo "Itu terlalu berharga untuk digunakan begitu saja.\n";
                } else {
                    echo "Belum ada aksi untuk item '$arg'.\n";
                }
                break;
            case 'save':
                save_game();
                break;
            case 'load':
                load_game();
                break;
            case 'exit':
            case 'quit':
                echo "Keluar. Sampai jumpa!\n";
                exit(0);
            default:
                echo "Perintah tidak dikenal. Ketik 'help' untuk bantuan.\n";
                break;
        }
    }
}

// ----------------------
// Init: sambut & set nama pemain jika mau
// ----------------------
echo "Masukkan nama pemain (kosong untuk 'Pemain'): ";
$name = trim(fgets(STDIN));
if ($name !== '') $state['player']['nama'] = $name;

main_loop();
