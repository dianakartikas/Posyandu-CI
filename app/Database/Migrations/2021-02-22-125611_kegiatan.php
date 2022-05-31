<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kegiatan extends Migration
{

	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_kader'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'nama'      => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',

			],
			'tanggal'     		 => [
				'type'           => 'DATETIME',
			],
			'lokasi'        => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',
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
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('kegiatan');
	}

	public function down()
	{
		$this->forge->dropTable('kegiatan');
	}
}
