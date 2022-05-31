<?php

namespace App\Database\Migrations;

class Warga extends \CodeIgniter\Database\Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user'          	 => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id'          	 	 => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null'			 => TRUE
			],
			'no_kk'         	 => [
				'type'           => 'VARCHAR',
				'constraint'     => '16',
			],
			'nama_ayah'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',
			],
			'nama_ibu'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',
			],
			'alamat'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '50',
			],
			'no_telp'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '16',
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
		$this->forge->addKey('id_user', TRUE);

		$this->forge->createTable('warga');
	}
	public function down()
	{
		$this->forge->dropTable('warga');
	}
}
