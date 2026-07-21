<?php
$jsonPath = '/run/media/diratittd/Gudang Data1/3-File App/GOLANG-NEXTJS-PROJECT/fintech-alazharapps/frontend/apps/apps/app/config/menu.json';
$jsonContent = file_get_contents($jsonPath);
$data = json_decode($jsonContent, true);

$rolesMap = [];

foreach ($data['menuSections'] as $section) {
    foreach ($section['items'] as $item) {
        $roles = $item['roles'] ?? [];
        foreach ($roles as $role) {
            if (empty($role)) continue;
            if (!isset($rolesMap[$role])) {
                $rolesMap[$role] = [];
            }
            $menuTitle = $section['title'] . " > " . $item['label'];
            $rolesMap[$role][] = $menuTitle;
        }
        if (isset($item['submenu']) && is_array($item['submenu'])) {
            foreach ($item['submenu'] as $sub) {
                $subRoles = $sub['roles'] ?? [];
                foreach ($subRoles as $role) {
                    if (empty($role)) continue;
                    if (!isset($rolesMap[$role])) {
                        $rolesMap[$role] = [];
                    }
                    $rolesMap[$role][] = $section['title'] . " > " . $item['label'] . " > " . $sub['label'];
                }
            }
        }
    }
}

// Generate Seeder class
$output = "<?php\n\nnamespace Database\Seeders;\n\nuse Illuminate\Database\Seeder;\nuse App\Models\Document;\nuse Illuminate\Support\Str;\n\nclass ArtikelSeeder extends Seeder\n{\n    public function run()\n    {\n";
foreach ($rolesMap as $role => $menus) {
    $roleName = ucwords(str_replace('_', ' ', $role));
    $htmlContent = "<h3>Daftar Akses Menu untuk Role: {$roleName}</h3><ul>";
    foreach ($menus as $menu) {
        $htmlContent .= "<li>{$menu}</li>";
    }
    $htmlContent .= "</ul>";
    
    $output .= "        Document::create([\n";
    $output .= "            'category_id' => 1, // Default category\n";
    $output .= "            'title' => 'Panduan Akses Menu: {$roleName}',\n";
    $output .= "            'slug' => Str::slug('Panduan Akses Menu: {$roleName}'),\n";
    $output .= "            'content' => '" . addslashes($htmlContent) . "',\n";
    $output .= "            'is_published' => true,\n";
    $output .= "            'created_by' => 1,\n";
    $output .= "            'order' => 0,\n";
    $output .= "        ]);\n\n";
}
$output .= "    }\n}\n";

file_put_contents('database/seeders/ArtikelSeeder.php', $output);
echo "Seeder generated successfully!\n";
