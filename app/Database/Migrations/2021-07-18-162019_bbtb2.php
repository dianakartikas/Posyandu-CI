<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bbtb2 extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'nobbtb'        => [
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
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
		$this->forge->addKey('nobbtb', TRUE);
		$this->forge->createTable('bbtb2');
	} //


	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('bbtb2');
	}
}
