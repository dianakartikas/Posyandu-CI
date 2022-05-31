<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CekImunisasi extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id_cek_imunisasi'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_imunisasi'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'id_kunjungan'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'id_pengurus'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'catatan'       		=> [
				'type'           => 'TEXT',
			],
			'umur'      => [
				'type'           => 'INT',
				'constraint'     => '3',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
				// 'default'        => 'current_timestamp()',
			],

		]);
		$this->forge->addKey('id_cek_imunisasi', TRUE);
		$this->forge->addForeignKey('id_imunisasi', 'imunisasi', 'id_imunisasi', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_kunjungan', 'kunjungan', 'id_kunjungan', 'CASCADE', 'CASCADE');
		$this->forge->createTable('cek_imunisasi');
	}

	public function down()
	{
		$this->forge->dropTable('cek_imunisasi');
	}
}
