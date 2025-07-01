<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'site..title',
                'display_name' => 'Título del sitio',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'site..description',
                'display_name' => 'Descripción del sitio',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'site.logo',
                'display_name' => 'Logo del sitio',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site',
            ),
            3 => 
            array (
                'id' => 5,
                'key' => 'admin.bg_image',
                'display_name' => 'Imagen de fondo del administrador',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            4 => 
            array (
                'id' => 6,
                'key' => 'admin.title',
                'display_name' => 'Título del administrador',
                'value' => 'Voyager',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            5 => 
            array (
                'id' => 7,
                'key' => 'admin.description',
                'display_name' => 'Descripción del administrador',
                'value' => 'Bienvenido a Voyager. El administrador que le faltaba a Laravel',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Admin',
            ),
            6 => 
            array (
                'id' => 8,
                'key' => 'admin.loader',
                'display_name' => 'Imagen de carga del administrador',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin',
            ),
            7 => 
            array (
                'id' => 9,
                'key' => 'admin.icon_image',
                'display_name' => 'Ícono del administrador',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin',
            ),
            8 => 
            array (
                'id' => 11,
                'key' => 'system.development',
                'display_name' => 'Sistema en Mantenimiento 503',
                'value' => '0',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 1,
                'group' => 'System',
            ),
            9 => 
            array (
                'id' => 12,
                'key' => 'system.payment-alert',
                'display_name' => 'Alerta de Pago',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 1,
                'group' => 'System',
            ),
            10 => 
            array (
                'id' => 13,
                'key' => 'system.code',
                'display_name' => 'Código',
                'value' => 'code-1',
                'details' => NULL,
                'type' => 'text',
                'order' => 2,
                'group' => 'System',
            ),
        ));
        
        
    }
}