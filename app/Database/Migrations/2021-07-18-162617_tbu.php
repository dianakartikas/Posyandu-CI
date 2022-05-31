<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tbu extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'notbu'        => [
				'type'           => 'VARCHAR',
				'constraint'     => '5',
			],
			'umur'     	 => [
				'type'           => 'int',
				'constraint'     => '2',
			],
			'jenis_kelamin'   => [
				'type'           => 'ENUM',
				'constraint'     => "'L','P'",
				'default'        => 'L',
			],
			'sdmin1'     		 => [
				'type'           => 'FLOAT'
			],
			'sdplus1'     		 => [
				'type'           => 'FLOAT'
			],
			'median'      	=> [
				'type'           => 'FLOAT',
			]
		]);
		$this->forge->addKey('notbu', TRUE);
		$this->forge->createTable('tbu');
	}
	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
