<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Imunisasi extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'id_imunisasi'          => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],

			'nama'       		 => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',
			],
			'dari_usia'     	 => [
				'type'           => 'int',
				'constraint'     => '5',
			],
			'sampai_usia'        => [
				'type'           => 'int',
				'constraint'     => '5',
			],
			'catatan'       		=> [
				'type'           => 'TEXT',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
				// 'default'        => 'current_timestamp()',
			],
			'updated_at'       => [
				'type'           => 'DATETIME',
				// 'default'        => 'current_timestamp()',
			]
		]);
		$this->forge->addKey('id_imunisasi', TRUE);
		$this->forge->createTable('imunisasi');
	}

	public function down()
	{
		$this->forge->dropTable('imunisasi');
	}
}
