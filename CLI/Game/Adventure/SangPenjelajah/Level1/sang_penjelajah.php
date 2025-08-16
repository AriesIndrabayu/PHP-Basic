<?php
// sang_penjelajah.php
// Game CLI - "Sang Penjelajah"
// Simpan & jalankan: php sang_penjelajah.php

// ----------------------
// ANSI color helper
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

$USE_COLOR = true;
function color($text, $col)
{
    global $USE_COLOR, $C;
    if (!$USE_COLOR) return $text;
    return $col . $text . $C->reset;
}
function color_code($name)
{
    global $C;
    return $C->$name ?? $C->reset;
}

// ----------------------
// Input util
// ----------------------
function ask($prompt = "> ")
{
    echo $prompt;
    $line = fgets(STDIN);
    if ($line === false) return '';
    return trim($line);
}

// ----------------------
// World & initial state
// ----------------------
$world = [
    'lokasi_awal' => 'desa',
    'map_order' => ['desa', 'hutan', 'gunung', 'gua'],
    'map' => [
        'desa' => [
            'nama' => 'Desa Siluman',
            'desc' => 'Desa kecil tempatmu memulai perjalanan. Kepala suku tahu banyak cerita.',
            'koneksi' => ['hutan', 'gunung'],
        ],
        'hutan' => [
            'nama' => 'Hutan Belantara',
            'desc' => 'Hutan lebat yang menjadi gerbang menuju gua berisi harta karun.',
            'koneksi' => ['desa', 'gua'],
        ],
        'gunung' => [
            'nama' => 'Puncak Gunung',
            'desc' => 'Jalur mendaki dengan 3 cabang jalan: puncak, air terjun, dan jalur hutan.',
            'koneksi' => ['desa'],
        ],
        'gua' => [
            'nama' => 'Gua Misterius',
            'desc' => 'Gua yang dijaga monster penjaga harta karun.',
            'koneksi' => ['hutan'],
        ],
    ],
];

$state = [
    'player' => [
        'nama' => 'Penjelajah',
        'lokasi' => $world['lokasi_awal'],
        'hp' => 100,
        'max_hp' => 100,
        'atk' => 50,        // kekuatan pemain awal (bisa disesuaikan)
        'xp' => 0,
        'level' => 1,
        "inventory" => [],
        "has_weapon" => false,
    ],
    'inventory' => [],    // misal 'senjata_khusus' => 1
    'has_weapon' => false,
    'time' => 0,
];

// Monsters (menggunakan nilai kekuatan yang menjadi perbandingan)
$monsters = [
    'serigala' => ['nama' => 'Serigala Liar', 'power' => 40, 'drop' => 'taring'],
    'goblin' => ['nama' => 'Goblin', 'power' => 30, 'drop' => 'koin'],
    'troll' => ['nama' => 'Troll Gunung', 'power' => 60, 'drop' => 'sisik'],
    'kelelawar' => ['nama' => 'Kelelawar Raksasa', 'power' => 45, 'drop' => 'kulit'],
    'penjaga_gua' => ['nama' => 'Penjaga Harta', 'power' => 120, 'drop' => 'harta_karun'],
];

// ----------------------
// Helpers: inventory, xp, status
// ----------------------
function add_item($item, $qty = 1)
{
    global $state;
    if (isset($state['inventory'][$item])) $state['inventory'][$item] += $qty;
    else $state['inventory'][$item] = $qty;
    echo color("Dapat: $item x$qty\n", color_code('yellow'));
}
function remove_item($item, $qty = 1)
{
    global $state;
    if (!isset($state['inventory'][$item])) return false;
    $state['inventory'][$item] -= $qty;
    if ($state['inventory'][$item] <= 0) unset($state['inventory'][$item]);
    return true;
}
function gain_xp($amount)
{
    global $state;
    $state['player']['xp'] += $amount;
    echo color("Mendapat $amount XP\n", color_code('cyan'));
    while ($state['player']['xp'] >= 100) {
        $state['player']['xp'] -= 100;
        $state['player']['level'] += 1;
        $state['player']['max_hp'] += 10;
        $state['player']['atk'] += 5;
        $state['player']['hp'] = $state['player']['max_hp'];
        echo color(">>> LEVEL UP! Sekarang level {$state['player']['level']}\n", color_code('magenta'));
    }
}




function show_status_table_old($p)
{
    $data = [
        ["🧍 Nama", ":", $p['nama']],
        ["📍 Lokasi", ":", $p['lokasi']],
        ["💖 HP", ":", "{$p['hp']}/{$p['max_hp']}"],
        ["⚔️ ATK", ":", $p['atk']],
        ["⭐ Level", ":", "{$p['level']} (XP: {$p['xp']})"],
        ["🎒 Item", ":", empty($p['inventory']) ? "(kosong)" : implode(', ', $p['inventory'])],
        ["🔑 Senjata", ":", $p['has_weapon'] ? "YA" : "TIDAK"],
    ];

    // Tentukan lebar kolom
    $col1_width = max(array_map(fn($row) => mb_strwidth($row[0], 'UTF-8'), $data));
    $col2_width = max(array_map(fn($row) => mb_strwidth($row[1], 'UTF-8'), $data));
    $col3_width = max(array_map(fn($row) => mb_strwidth($row[2], 'UTF-8'), $data));

    $total_width = $col1_width + $col2_width + $col3_width + 7; // padding & garis

    // Garis atas
    echo "╔" . str_repeat("═", $col1_width + 2) . "╦" . str_repeat("═", $col2_width + 2) . "╦" . str_repeat("═", $col3_width + 2) . "╗\n";

    // Isi tabel
    foreach ($data as $row) {
        $col1_pad = $col1_width - mb_strwidth($row[0], 'UTF-8');
        $col2_pad = $col2_width - mb_strwidth($row[1], 'UTF-8');
        $col3_pad = $col3_width - mb_strwidth($row[2], 'UTF-8');
        echo "║ " . $row[0] . str_repeat(" ", $col1_pad) .
            "║ " . $row[1] . str_repeat(" ", $col2_pad) .
            " ║ " . $row[2] . str_repeat(" ", $col3_pad) . " ║\n";
    }

    // Garis bawah
    echo "╚" . str_repeat("═", $col1_width + 2) . "╩" . str_repeat("═", $col2_width + 2) . "╩" . str_repeat("═", $col3_width + 2) . "╝\n";
}

function wrap_text($text, $width)
{
    $result = [];
    $line = '';
    $words = preg_split('/\s+/', $text);

    foreach ($words as $word) {
        if (mb_strwidth(($line === '' ? '' : $line . ' ') . $word, 'UTF-8') <= $width) {
            $line .= ($line === '' ? '' : ' ') . $word;
        } else {
            $result[] = $line;
            $line = $word;
        }
    }
    if ($line !== '') {
        $result[] = $line;
    }

    return $result;
}
function show_status_table($p)
{
    $data = [
        ["🧍 Nama", ":", $p['nama']],
        ["📍 Lokasi", ":", $p['lokasi']],
        ["💖 HP", ":", "{$p['hp']}/{$p['max_hp']}"],
        ["⚔️  ATK", ":", $p['atk']],
        ["⭐ Level", ":", "{$p['level']} (XP: {$p['xp']})"],
        ["🎒 Item", ":", empty($p['inventory']) ? "(kosong)" : implode(', ', $p['inventory'])] . " Tes kalimat jika disini banyak teks",
        ["🔑 Senjata", ":", $p['has_weapon'] ? "YA" : "TIDAK"],
    ];

    // Tentukan lebar kolom
    $col1_width = max(array_map(fn($row) => mb_strwidth($row[0], 'UTF-8'), $data));
    $col2_width = max(array_map(fn($row) => mb_strwidth($row[1], 'UTF-8'), $data));
    $col3_width = max(array_map(fn($row) => mb_strwidth($row[2], 'UTF-8'), $data));

    $total_width = $col1_width + $col2_width + $col3_width + 7; // padding & garis

    // Garis atas
    echo "╔" . str_repeat("═", $col1_width + 2) . str_repeat("═", $col2_width + 1) . str_repeat("═", $col3_width) . "╗\n";

    // Isi tabel
    foreach ($data as $row) {
        $lebarKata = mb_strwidth($row[0]);
        $col1_pad = $col1_width - mb_strwidth($row[0], 'UTF-8');
        $col2_pad = $col2_width - mb_strwidth($row[1], 'UTF-8');
        $col3_pad = $col3_width - mb_strwidth($row[2], 'UTF-8');

        if ($row[0] == "⚔️  ATK") {
            $lebar_kolom = $col1_pad + 2;
        } else {
            $lebar_kolom = $col1_pad + 1;
        }
        $textValue = "";
        foreach (wrap_text($row[2], $col2_width) as $line) {
            // Tambah spasi agar rata kanan
            $pad = $col2_width - mb_strwidth($line, 'UTF-8');
            $textValue = $line . str_repeat(" ", $pad);
        }

        echo "║ " . $row[0] . str_repeat(" ", $lebar_kolom) .
            $row[1] . str_repeat(" ", $col2_pad) .
            $textValue . str_repeat(" ", $col3_pad) . " ║\n";
        // echo "lebar kolom: {$col1_pad}/{$col1_width}/{$lebarKata} - {$col2_pad} - {$col3_pad}\n";
    }


    // Garis bawah
    echo "╚" . str_repeat("═", $col1_width + 2) . str_repeat("═", $col2_width + 1) . str_repeat("═", $col3_width) . "╝\n";
}

function show_status_rpg($p)
{
    show_status_table($p);
}

function show_status_rpg_old($p)
{
    $width_content = 24; // lebar area isi di antara "║" dan "║"

    $fields = [
        "🧍 Nama   : {$p['nama']}",
        "📍 Lokasi : {$p['lokasi']}",
        "💖 HP     : {$p['hp']}/{$p['max_hp']}",
        "⚔️ ATK    : {$p['atk']}",
        "⭐ Level  : {$p['level']} (XP: {$p['xp']})",
        "🎒 Item   : " . (empty($p['inventory']) ? "(kosong)" : implode(', ', $p['inventory'])),
        "🔑 Senjata: " . ($p['has_weapon'] ? "YA" : "TIDAK"),
    ];
    // Cari panjang maksimal untuk menentukan lebar box
    $max_length = 0;
    foreach ($fields as $field) {
        $length = mb_strwidth($field, 'UTF-8');
        if ($length > $max_length) {
            $max_length = $length;
        }
    }

    // Lebar konten mengikuti teks terpanjang
    $width_content = $max_length;

    // Cetak header box
    echo "╔" . str_repeat("═", $width_content + 2) . "╗\n";
    foreach ($fields as $field) {
        foreach (wrap_text($field, $width_content) as $line) {
            // Tambah spasi agar rata kanan
            $pad = $width_content - mb_strwidth($line, 'UTF-8');
            echo "║ " . $line . str_repeat(" ", $pad) . " ║\n";
        }
    }
    // Cetak footer box
    echo "╚" . str_repeat("═", $width_content + 2) . "╝\n";
}
function show_status()
{
    global $state;
    $p = $state['player'];
    echo color("=== STATUS ===\n", color_code('bold'));
    echo "Nama: {$p['nama']}\n";
    echo "Lokasi: {$p['lokasi']}\n";
    echo "\u{1F496}HP (Health Points): {$p['hp']}/{$p['max_hp']}\n";
    echo "\u{2694}\u{FE0F}ATK (Attack Power / Kekuatan): {$p['atk']}\n";
    echo "Level: {$p['level']} (XP: {$p['xp']})\n";
    echo "Inventory: ";
    if (empty($state['inventory'])) echo "(kosong)\n";
    else {
        $items = [];
        foreach ($state['inventory'] as $k => $v) $items[] = "$k(x$v)";
        echo implode(", ", $items) . "\n";
    }
    echo "Senjata khusus: " . ($state['has_weapon'] ? 'YA' : 'TIDAK') . "\n";
}

// ----------------------
// Save / Load
// ----------------------
function save_game($file = 'sang_save.json')
{
    global $state;
    $d = json_encode($state, JSON_PRETTY_PRINT);
    if (file_put_contents($file, $d) !== false) {
        echo color("Game tersimpan: $file\n", color_code('green'));
    } else {
        echo color("Gagal menyimpan.\n", color_code('red'));
    }
}
function load_game($file = 'sang_save.json')
{
    global $state;
    if (!file_exists($file)) {
        echo color("File save tidak ditemukan.\n", color_code('yellow'));
        return false;
    }
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    if ($data === null) {
        echo color("File save rusak.\n", color_code('red'));
        return false;
    }
    $state = $data;
    echo color("Save berhasil dimuat dari $file\n", color_code('green'));
    return true;
}

// ----------------------
// Combat: "cek kekuatan" mode (scripted fight rule)
// Jika atk pemain > power monster -> menang, atk pemain naik.
// Jika <= -> kalah (game over).
// ----------------------
function fight_check_strength($monster_key, $bonusAtkOnWin = 5)
{
    global $monsters, $state;
    if (!isset($monsters[$monster_key])) {
        echo color("Monster tidak dikenal.\n", color_code('yellow'));
        return false;
    }
    $m = $monsters[$monster_key];
    $playerAtk = $state['player']['atk'];
    echo color("!!! Pertarungan: {$m['nama']} (Kekuatan: {$m['power']})\n", color_code('red'));
    echo "Kekuatanmu: $playerAtk\n";
    // perbandingan simpel
    if ($playerAtk > $m['power']) {
        echo color(">>> Kamu MENANG melawan {$m['nama']}!\n", color_code('green'));
        // naikkan kekuatan pemain
        $gain = $bonusAtkOnWin + intval($m['power'] / 10); // bonus tergantung monster
        $state['player']['atk'] += $gain;
        echo color("Kekuatanmu bertambah +$gain (sekarang {$state['player']['atk']}).\n", color_code('yellow'));
        // drop (jika ada)
        if (!empty($m['drop'])) add_item($m['drop'], 1);
        gain_xp(20);
        return true;
    } else {
        echo color(">>> Kamu KALAH. Monster terlalu kuat.\n", color_code('red'));
        echo color("Game Over.\n", color_code('red'));
        exit(0);
    }
}

// ----------------------
// Scripted encounters untuk hutan/gunung/gua
// ----------------------
function hutan_challenge()
{
    // wajib hadapi 3 monster berurutan
    echo color("🌲 Kamu memasuki Hutan Belantara. Untuk lanjut, kamu harus mengalahkan 3 monster.\n", color_code('blue'));
    // pilih 3 monster random dari daftar kecil
    $pool = ['serigala', 'goblin', 'kelelawar'];
    for ($i = 1; $i <= 3; $i++) {
        echo color("\n-- Monster ke-$i --\n", color_code('bold'));
        $mkey = $pool[array_rand($pool)];
        fight_check_strength($mkey, 5);
    }
    echo color("\nSelamat! Kamu berhasil melewati hutan dan bisa masuk ke Gua.\n", color_code('green'));
}

function gunung_branch_puncak()
{
    // cabang 1: puncak (tantangan berat) -> dapat senjata
    echo color("⛰️ Kamu memilih jalur menuju Puncak Gunung. Jalur berat menantang nyalimu.\n", color_code('blue'));
    // tantangan: 2-3 monster berturut-turut (acak antara 2-3)
    $count = rand(2, 3);
    $pool = ['troll', 'serigala', 'kelelawar'];
    for ($i = 1; $i <= $count; $i++) {
        echo color("\n-- Tantangan Puncak: Monster ke-$i --\n", color_code('bold'));
        $mkey = $pool[array_rand($pool)];
        // tantangan puncak lebih keras; beri bonusAtkOnWin lebih besar
        fight_check_strength($mkey, 10);
        // juga kurangi HP sedikit untuk menggambarkan hampir mati
        global $state;
        $dmg = rand(5, 20);
        $state['player']['hp'] -= $dmg;
        if ($state['player']['hp'] <= 0) {
            echo color("Kamu hampir tewas di puncak... namun cerita ini menyatakan kamu terselamatkan? (Game Over)\n", color_code('red'));
            exit(0);
        } else {
            echo color("Setelah pertarungan, kondisimu sedikit luka: -$dmg HP (HP sekarang {$state['player']['hp']}).\n", color_code('yellow'));
        }
    }
    // dapat senjata khusus
    echo color("\n🎯 Kamu mencapai Puncak dan menemukan Senjata Pembunuh Monster!\n", color_code('magenta'));
    global $state;
    $state['has_weapon'] = true;
    add_item('senjata_khusus', 1);
    // setelah dapat senjata, pemain kembali ke desa (sesuai alur)
    echo color("Kau menuruni gunung dan kembali ke Desa untuk beristirahat.\n", color_code('cyan'));
    $state['player']['lokasi'] = 'desa';
    return;
}

function gunung_branch_air_terjun()
{
    global $state;
    echo color("💧 Kamu menuju Air Terjun. Saat menyeberangi sungai, kamu terpeleset dan terseret arus!\n", color_code('blue'));
    echo "Beruntung ada penduduk desa yang menemukamu dan membawamu pulang ke Kepala Suku.\n";
    $state['player']['lokasi'] = 'desa';
    // sedikit kehilangan HP tapi tidak fatal
    if (!isset($state['player']['hp'])) {
        $state['player']['hp'] = 100; // default kalau belum ada
    }
    $damage = rand(5, 12);;
    // $state['player']['hp'] = max(1, $state['player']['hp'] - $lost);
    $state['player']['hp'] -= $damage;
    if ($state['player']['hp'] < 0) {
        $state['player']['hp'] = 0;
    }
    echo color("HP berkurang $damage karena kejadian, tapi kamu selamat (HP sekarang {$state['player']['hp']}).\n", color_code('yellow'));
    return;
}

function gunung_branch_hutan()
{
    global $state;
    echo color("🌳 Dari gunung kamu masuk jalur kecil yang menuju Hutan. Monster muncul di jalur!\n", color_code('blue'));
    echo "Pilihan: [lari] kembali ke desa atau [bertarung] melanjutkan.\n";
    $cmd = ask("> ");
    if (strtolower($cmd) === 'lari' || strtolower($cmd) === 'kembali') {
        echo color("Kamu berhasil kembali ke Desa dengan selamat.\n", color_code('green'));
        $state['player']['lokasi'] = 'desa';
        return;
    } else {
        // jika bertarung, coba satu monster & lanjut (TAPI tanpa senjata, resiko tinggi)
        echo color("Kamu memilih bertarung di jalur hutan...\n", color_code('yellow'));
        $mkey = 'serigala';
        fight_check_strength($mkey, 5);
        // jika menang, nyasar ke gua (sesuai skenario: langsung ke gua dan kemungkinan mati tanpa senjata)
        echo color("Usai pertarungan, jalur membawa kamu ke Gua!\n", color_code('cyan'));
        $state['player']['lokasi'] = 'gua';
        // langsung lakukan encounter boss (penjaga gua)
        if (isset($state['player']['has_weapon']) && $state['player']['has_weapon'] === true) {
            fight_check_strength('penjaga_gua', 20);
            // jika menang, dapat harta karun
            add_item('harta_karun', 1);
            echo color("Kamu mengambil Harta Karun!\n", color_code('magenta'));
            // kembali desa nanti oleh flow lain
        } else {
            echo color("Waduh! Kamu tidak punya senjata pembunuh monster. Penjaga gua terlalu kuat.\n", color_code('red'));
            fight_check_strength('penjaga_gua', 0); // ini pasti akan memicu kalah & exit jika atk kurang
        }
        return;
    }
}

function enter_gua()
{
    global $state;
    echo color("🕳️ Kamu masuk ke Gua Misterius...\n", color_code('blue'));
    // kalau pemain tidak punya senjata -> tidak bisa kalahkan penjaga
    if (!$state['has_weapon']) {
        $damage = rand(40, 60);
        $state['player']['hp'] -= $damage;
        if ($state['player']['hp'] < 0) {
            $state['player']['hp'] = 0;
        }
        echo color("Di dalam gua ada Penjaga Harta yang sangat kuat. Kamu butuh senjata pembunuh monster dari puncak gunung.\n", color_code('red'));
        echo "Kamu tidak bisa melanjutkan dan kembali ke Desa penuh luka dengan malu-malu minta disembuhin kepala suku.\n";
        echo color("HP berkurang {$damage} karena kejadian di dalam goa, tapi kamu selamat (HP sekarang {$state['player']['hp']}).\n", color_code('yellow'));
        $state['player']['lokasi'] = 'desa';
        return;
    }
    // jika punya senjata -> bertarung dengan penjaga
    echo color("Kamu menantang Penjaga Harta!\n", color_code('magenta'));
    fight_check_strength('penjaga_gua', 30);
    // jika menang:
    add_item('harta_karun', 1);
    echo color("🎉 Selamat! Kamu mendapatkan Harta Karun!\n", color_code('yellow'));
    // berikan reward quest: misal koin & xp
    add_item('koin', 50);
    gain_xp(50);
    // kembali ke desa selesai level 1
    echo color("Kamu kembali ke Desa membawa Harta Karun untuk Kepala Suku.\n", color_code('cyan'));
    $state['player']['lokasi'] = 'desa';
    // event akhir level:
    echo color("\n=== EPILOGUE LEVEL 1 ===\n", color_code('bold'));
    echo "Kepala Suku menerima harta karun. Desa Siluman jadi sejahtera dan ia memberimu Jimat Mustika.\n";
    add_item('jimat_mustika', 1);
    echo color("Level 1 selesai. Si Penjelajah melanjutkan perjalanannya...\n", color_code('magenta'));
}

// ----------------------
// Interaksi Kepala Suku di Desa
// ----------------------
function tanya_kepala_suku()
{
    global $state;
    echo color("🏛️ Kamu menemui Kepala Suku.\n", color_code('blue'));
    echo "\"Anak muda, senjata pembunuh monster ada di puncak gunung. Tapi banyak jalur berbahaya. Pilihlah bijak.\"\n";
    echo "Pilihan yang tersedia:\n";
    echo "1. Pergi ke Gunung (pilih cabang setelah tiba)\n";
    echo "2. Pergi ke Hutan (langsung hadapi 3 monster lalu Gua)\n";
    echo "3. Tanya lagi\n";
    echo "0. Kembali\n";
    $pil = ask("> ");
    if ($pil === "1") {
        // pindah ke gunung
        $state['player']['lokasi'] = 'gunung';
        echo color("Kamu bergerak menuju Gunung.\n", color_code('cyan'));
        // handle gunung cabang
        handle_gunung();
    } elseif ($pil === "2") {
        $state['player']['lokasi'] = 'hutan';
        echo color("Kamu bergerak menuju Hutan.\n", color_code('cyan'));
        hutan_challenge();
        // setelah hutan selesai, otomatis masuk gua
        enter_gua();
    } elseif ($pil === "3") {
        echo "\"Ingat, tanpa senjata khusus kau tak akan menaklukkan penjaga gua.\"\n";
    } else {
        echo "Kamu kembali.\n";
    }
}

// ----------------------
// Gunung: pilih cabang jalan
// ----------------------
function handle_gunung()
{
    global $state;
    echo color("\n=== GUNUNG: Pilih Cabang Jalan ===\n", color_code('bold'));
    echo "1. Cabang 1: Menuju Puncak (tantangan berat, ada hadiah senjata)\n";
    echo "2. Cabang 2: Air Terjun (resiko terpeleset, dibawa pulang)\n";
    echo "3. Cabang 3: Jalur Hutan (bisa memimpin langsung ke Gua)\n";
    echo "0. Kembali ke Desa\n";
    $c = ask("> ");
    if ($c === "1") {
        gunung_branch_puncak();
        // setelah puncak, di-alur kita kembali ke desa dan pasien pulih pada kepala suku
        echo color("Kembalilah menemui Kepala Suku untuk mengobati luka-lukamu.\n", color_code('cyan'));
        $state['player']['lokasi'] = 'desa';
        // pulihkan HP saat bertemu kepala suku
        echo color("Kamu menemui Kepala Suku yang merawat lukamu. HP pulih 100%.\n", color_code('green'));
        $state['player']['hp'] = $state['player']['max_hp'];
    } elseif ($c === "2") {
        gunung_branch_air_terjun();
    } elseif ($c === "3") {
        gunung_branch_hutan();
    } else {
        echo "Kembali ke Desa.\n";
        $state['player']['lokasi'] = 'desa';
    }
}

// ----------------------
// Command loop & routing
// ----------------------
function show_help()
{
    echo color("Perintah umum:\n", color_code('bold'));
    echo "- look / lihat      : melihat sekitar\n";
    echo "- tanya / kepala    : tanya Kepala Suku (hanya di Desa)\n";
    echo "- obat / minta tolong : minta Kepala Suku mengobati HP (hanya di Desa)\n";
    echo "- go <lokasi>       : pindah lokasi (desa/hutan/gunung/gua)\n";
    echo "- status / stat     : lihat status\n";
    echo "- inv / inventory   : lihat inventori\n";
    echo "- use <item>        : pakai item\n";
    echo "- save / load       : simpan / muat game\n";
    echo "- help              : bantuan\n";
    echo "- exit / quit       : keluar game\n";
}

function look_around()
{
    global $world, $state;
    $loc = $state['player']['lokasi'];
    $info = $world['map'][$loc];
    echo color("== " . $info['nama'] . " ==\n", color_code('bold'));
    echo $info['desc'] . "\n";
    echo "Jalan: " . implode(", ", $info['koneksi']) . "\n";
}

function move_to($to)
{
    global $world, $state;
    if (!isset($world['map'][$to])) {
        echo color("Lokasi '$to' tidak dikenal.\n", color_code('yellow'));
        return;
    }
    // validasi koneksi sederhana: from desa -> hutan/gunung; from gunung -> desa; from hutan->desa/gua; etc
    $from = $state['player']['lokasi'];
    if (!in_array($to, $world['map'][$from]['koneksi']) && !($from == 'gunung' && $to == 'desa')) {
        // allow explicit return to desa from gunung handled by koneksi above
        echo color("Tidak ada jalan langsung dari $from ke $to.\n", color_code('yellow'));
        return;
    }
    $state['player']['lokasi'] = $to;
    echo color("Kamu bergerak ke $to.\n", color_code('cyan'));
    // jalankan event per lokasi
    if ($to === 'hutan') {
        // hutan: wajib 3 monster
        hutan_challenge();
        // setelah hutan, masuk gua otomatis
        enter_gua();
    } elseif ($to === 'gunung') {
        // di gunung, pilih cabang
        handle_gunung();
    } elseif ($to === 'gua') {
        // langsung cek gua
        enter_gua();
    } elseif ($to === 'desa') {
        echo color("Kamu kembali ke Desa. Kamu bisa menemui Kepala Suku.\n", color_code('cyan'));
    }
}

// main loop
function main_loop()
{
    global $state;
    echo color("=== SANG PENJELAJAH - LEVEL 1 ===\n", color_code('bold'));
    echo "Ketik 'help' untuk melihat perintah.\n";
    while (true) {
        echo "\n[" . $state['player']['lokasi'] . "] ";
        $input = ask("> ");
        if ($input === '') continue;
        $parts = preg_split('/\s+/', trim($input));
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
            case 'obat':
            case 'minta':
            case 'minta tolong':
                if ($state['player']['lokasi'] === 'desa') {
                    echo "🏥 Kamu mendatangi Kepala Suku untuk minta diobati...\n";
                    sleep(1);
                    echo "\"Tenang anak muda, aku akan mengobati lukamu,\" kata Kepala Suku.\n";
                    sleep(1);
                    $state['player']['hp'] = 100;
                    echo "✨ HP kamu telah pulih sepenuhnya! (HP sekarang {$state['player']['hp']})\n";
                } else {
                    echo "❌ Kamu harus berada di Desa untuk minta diobati.\n";
                }
                break;

            case 'tanya':
            case 'kepala':
                if ($state['player']['lokasi'] !== 'desa') {
                    echo "Kamu harus di Desa untuk menemui Kepala Suku.\n";
                } else {
                    tanya_kepala_suku();
                }
                break;
            case 'go':
            case 'ke':
                if (!$arg) {
                    echo "Ke mana? (desa/hutan/gunung/gua)\n";
                    break;
                }
                move_to($arg);
                break;
            case 'status':
            case 'stat':
                // show_status();
                show_status_rpg($state['player']);
                break;
            case 'inv':
            case 'inventory':
                echo color("== INVENTORY ==\n", color_code('bold'));
                if (empty($state['inventory'])) echo "(kosong)\n";
                else {
                    foreach ($state['inventory'] as $it => $q) echo "- $it x$q\n";
                }
                break;
            case 'use':
                if (!$arg) {
                    echo "Use apa?\n";
                    break;
                }
                if ($arg === 'koin') {
                    if (isset($state['inventory']['koin']) && $state['inventory']['koin'] > 0) {
                        remove_item('koin', 1);
                        $state['player']['hp'] = min($state['player']['max_hp'], $state['player']['hp'] + 10);
                        echo "Kamu menggunakan koin untuk mendapatkan obat. HP +10.\n";
                    } else echo "Tidak punya koin.\n";
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
                break;
            default:
                echo "Perintah tidak dikenal. Ketik 'help' untuk daftar perintah.\n";
                break;
        }
    }
}

function menuUtama()
{
    echo "=== SANG PENJELAJAH ===\n";
    echo "1. Petualangan Baru\n";
    echo "2. Load Game\n";
    echo "3. Keluar\n";
    echo "Pilih: ";
    $pilihan = trim(fgets(STDIN));

    return $pilihan;
}

function petualanganBaru()
{
    global $state;
    echo "Masukkan nama Penjelajah (kosong = 'Penjelajah'): ";
    $nama = trim(fgets(STDIN));
    if ($nama === "") {
        $nama = "Penjelajah";
    }
    echo "Halo, $nama! Petualanganmu dimulai...\n";

    // Simpan progress awal
    // $data = [
    //     'nama' => $nama,
    //     'level' => 1,
    //     'hp' => 100
    // ];
    // file_put_contents('savegame.json', json_encode($data));
    $state['player']['nama'] = $nama;
    save_game();
}

function loadGame()
{
    if (!file_exists('sang_save.json')) {
        echo "Belum ada game tersimpan.\n";
        return;
    }

    $data = json_decode(file_get_contents('sang_save.json'), true);
    echo "Selamat datang kembali, {$data['player']['nama']}!\n";
    echo "Level: {$data['player']['level']} | HP: {$data['player']['hp']}\n";
    echo "Lanjutkan petualangan...\n";
}

// ----------------------
// Init & start
// ----------------------
// echo "Masukkan nama Penjelajah (kosong = 'Penjelajah'): ";
// $name = trim(fgets(STDIN));
// if ($name !== '') $state['player']['nama'] = $name;
// echo color("Selamat datang, {$state['player']['nama']}! Level 1: Misi Desa Siluman.\n", color_code('bold'));
// main_loop();
while (true) {
    $pilihan = menuUtama();
    if ($pilihan == "1") {
        petualanganBaru();
        main_loop();
    } elseif ($pilihan == "2") {
        loadGame();
        main_loop();
    } elseif ($pilihan == "3") {
        echo "Sampai jumpa!\n";
        break;
    } else {
        echo "Pilihan tidak valid.\n";
    }
}
