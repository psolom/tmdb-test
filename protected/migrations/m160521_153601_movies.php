<?php

class m160521_153601_movies extends CDbMigration
{
	public function up()
	{
		$this->createTable('movies', array(
			'id' => 'pk',
			'movie_id' => 'integer NOT NULL',
			'title' => 'string NOT NULL',
			'original_title' => 'string NOT NULL',
			'release_date' => 'datetime',
			'runtime' => 'datetime',
			'overview' => 'text',
			'genres' => 'text',
			'poster_path' => 'string NOT NULL',
		));
	}

	public function down()
	{
		echo "m160521_153601_movies does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}