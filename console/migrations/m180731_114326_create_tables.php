<?php

use yii\db\Migration;

/**
 * Class m180731_114326_create_tables
 */
class m180731_114326_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'sef_url' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'short_description' => $this->text()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
        ]);

        $this->addForeignKey('FK_news_category', '{{%news}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_category_id', '{{%news}}', 'category_id');

        $this->batchInsert('{{%category}}', ['name','lft', 'rgt', 'depth'], [
            ['Список категорий', 1, 2, 0]
        ]);

        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->defaultValue(null),
            'text' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('FK_comments_news', '{{%comments}}', 'model_id', '{{%news}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%comments}}');
        $this->dropTable('{{%news}}');
        $this->dropTable('{{%category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_114326_create_tables cannot be reverted.\n";

        return false;
    }
    */
}
