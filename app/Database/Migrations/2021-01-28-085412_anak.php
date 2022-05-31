<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anak extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id_anak'            => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'id_user'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'nama'		     => [
				'type'           => 'VARCHAR',
				'constraint'     => '25',
			],
			'jenis_kelamin'   => [
				'type'           => 'ENUM',
				'constraint'     => "'L','P'",
				'default'        => 'L',
			],
			'tanggal_lahir'       => [
				'type'           => 'DATE',
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
		$this->forge->addKey('id_anak', TRUE);
		$this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('anak');
	}

	public function down()
	{
		$this->forge->dropTable('anak');
	}
}
