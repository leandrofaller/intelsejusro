<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UnidadesTableSeeder');
        $this->call('CarceragemTableSeeder');
        $this->call('CelaTableSeeder');
        
        $this->call('EstadosTableSeeder');
        $this->call('CidadesTableSeeder');
        $this->call('EstadoCivilTableSeeder');

        $this->call('UsersTableSeed');

		$this->call('AppTableSeeder');
		$this->call('AppActionTableSeeder');
		$this->call('AppRoleTableSeeder');
		$this->call('AppActionRoleTableSeeder');
		$this->call('AppMenuTableSeeder');
		$this->call('AppMenuChildrenTableSeed');
		$this->call('AppRoleUserTableSeeder');
        
    }
}
