<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kunjungan extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id_kunjungan'       => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_kms'             => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE
			],
			'id_kegiatan'     	 => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE
			],
			'status'   => [
				'type'           => 'ENUM',
				'constraint'     => "'selesai','proses','terlewat','antri'",

			],
			'kode'   => [
				'type'           => 'VARCHAR',
				'constraint'     => '10',
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
		$this->forge->addKey('id_kunjungan', TRUE);
		$this->forge->createTable('kunjungan');
		$this->forge->addForeignKey('id_kms', 'kms', 'id_kms', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_kegiatan', 'kegiatan', 'id', 'CASCADE', 'CASCADE');
	}
	public function down()
	{
		$this->forge->dropTable('kunjungan');
	}
}
