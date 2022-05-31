<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kms extends Migration
{

	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id_kms'          => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],

			'id_anak'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'null' 			 => TRUE

			],
			'bb_lahir'     	 => [
				'type'           => 'int',
				'constraint'     => '5',
			],
			'tb_lahir'        => [
				'type'           => 'int',
				'constraint'     => '5',
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
		$this->forge->addKey('id_kms', TRUE);
		$this->forge->addForeignKey('id_anak', 'anak', 'id_anak', 'CASCADE', 'CASCADE');
		$this->forge->createTable('kms');
	}

	public function down()
	{
		$this->forge->dropTable('kms');
	}
}
