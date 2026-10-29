<?php

declare(strict_types=1);

$dir = __DIR__ . '/../public/templates';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$rows = [
    ['kata_kunci', 'kecocokan', 'tipe', 'pesan_balasan', 'pilihan_menu', 'jeda_detik'],
    ['halo', 'contain', 'text', "Halo! Selamat datang di Layanan CS Kami.\nKetik *menu* untuk melihat daftar layanan.", '', 1],
    ['menu', 'exact', 'button', "Silakan pilih salah satu menu di bawah:", "1: Info Produk: info | 2: Lokasi Kantor: lokasi | 3: Hubungi Admin: cs", 1],
    ['info', 'exact', 'text', "Produk kami melayani WhatsApp Gateway SAAS untuk notifikasi bisnis dan OTP instan.", '', 1],
    ['lokasi', 'exact', 'text', "Kantor operasional kami berlokasi di Jakarta Pusat.\nBuka Senin - Jumat pukul 08:00 - 17:00 WIB.", '', 1],
    ['survey', 'exact', 'poll', "Bagaimana kualitas respon layanan kami?", "Sangat Puas\nPuas\nCukup\nKurang Puas", 2],
];

$strings = []; $lookup = [];
$addStr = function(string $s) use (&$strings, &$lookup): int {
    if (!isset($lookup[$s])) { $lookup[$s] = count($strings); $strings[] = $s; }
    return $lookup[$s];
};

$sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><dimension ref="A1:F6"/><sheetViews><sheetView tabSelected="1" workbookViewId="0"/></sheetViews><sheetFormatPr defaultRowHeight="15"/><cols><col min="1" max="1" width="18" customWidth="1"/><col min="2" max="2" width="14" customWidth="1"/><col min="3" max="3" width="12" customWidth="1"/><col min="4" max="4" width="45" customWidth="1"/><col min="5" max="5" width="45" customWidth="1"/><col min="6" max="6" width="12" customWidth="1"/></cols><sheetData>';
$colLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
foreach ($rows as $rIdx => $row) {
    $rNum = $rIdx + 1;
    $sheetXml .= "<row r=\"{$rNum}\" spans=\"1:6\">";
    foreach ($row as $cIdx => $val) {
        $ref = $colLetters[$cIdx] . $rNum;
        if ($val === '' || $val === null) {
            $sheetXml .= "<c r=\"{$ref}\"/>";
        } elseif (is_int($val) && $rNum > 1) {
            $sheetXml .= "<c r=\"{$ref}\"><v>{$val}</v></c>";
        } else {
            $sIdx = $addStr((string) $val);
            $sheetXml .= "<c r=\"{$ref}\" t=\"s\"" . ($rNum === 1 ? ' s="1"' : '') . "><v>{$sIdx}</v></c>";
        }
    }
    $sheetXml .= '</row>';
}
$sheetXml .= '</sheetData></worksheet>';

$sharedXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($strings) . '" uniqueCount="' . count($strings) . '">';
foreach ($strings as $str) {
    $sharedXml .= '<si><t xml:space="preserve">' . htmlspecialchars($str, ENT_XML1, 'UTF-8') . '</t></si>';
}
$sharedXml .= '</sst>';

$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><color theme="1"/><name val="Calibri"/><family val="2"/></font><font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/><family val="2"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF16A36A"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles><dxfs count="0"/><tableStyles count="0" defaultTableStyle="TableStyleMedium9" defaultPivotStyle="PivotStyleLight16"/></styleSheet>';

$zip = new ZipArchive();
$xlsxFile = $dir . '/template_autoreply.xlsx';
if ($zip->open($xlsxFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/><Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStringItem+xml"/></Types>');
    $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
    $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/></Relationships>');
    $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><bookViews><workbookView xWindow="0" yWindow="0" windowWidth="20480" windowHeight="10240"/></bookViews><sheets><sheet name="Template AutoReply" sheetId="1" r:id="rId1"/></sheets></workbook>');
    $zip->addFromString('xl/styles.xml', $stylesXml);
    $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
    $zip->addFromString('xl/sharedStrings.xml', $sharedXml);
    $zip->close();
}

$csvFile = $dir . '/template_autoreply.csv';
$cf = fopen($csvFile, 'w');
if ($cf) {
    fputs($cf, "\xEF\xBB\xBF");
    foreach ($rows as $r) { fputcsv($cf, $r); }
    fclose($cf);
}
echo "OK\n";
