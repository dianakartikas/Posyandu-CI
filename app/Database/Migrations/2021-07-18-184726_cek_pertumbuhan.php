<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CekPertumbuhan extends Migration
{

	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id_cek_pertumbuhan'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_kunjungan'       => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE
			],
			'umur'     			 => [
				'type'           => 'INT',
				'constraint'     => '3',
			],
			'tinggi_badan'     	 => [
				'type'           => 'INT',
				'constraint'     => '3',
			],
			'berat_badan'      	=> [
				'type'           => 'INT',
				'constraint'     => '3',
			],
			'tanggal'     		 => [
				'type'           => 'DATETIME',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
				// 'default'        => 'current_timestamp()',
			],
			'catatan'       		=> [
				'type'           => 'TEXT',
			],
			'hasil'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '20',
			],
		]);
		$this->forge->addKey('id_cek_pertumbuhan', TRUE);
		$this->forge->addForeignKey('id_kunjungan', 'kunjungan', 'id_kunjungan', 'CASCADE', 'CASCADE');
		$this->forge->createTable('cek_pertumbuhan');
	}

	public function down()
	{
		$this->forge->dropTable('cek_pertumbuhan');
	}
}
