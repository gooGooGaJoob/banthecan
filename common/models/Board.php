<?php

namespace common\models;

use Faker\Factory;
use yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $title
 * @property string $description
 * @property integer $max_lanes
 * @property integer $entry_column
 * @property BoardColumn[] $boardColumns
 *
 */
class Board extends \yii\db\ActiveRecord {

    const NO_ACTIVE_BOARD_MESSAGE = 'An Active Board Has Not Been Set';
    const NO_ACTIVE_BOARD_STATUS_TEST = 0;
    const DEMO_TITLE = 'Ban-The-Can Demonstration Board';
    const DEMO_MAX_LANES = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {

        return 'board';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {

        return [
            [['title', 'description', 'max_lanes', 'entry_column'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'max_lanes', 'entry_column'], 'integer'],
            [['title', 'description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'description' => 'Description',
            'max_lanes' => 'Max Lanes',
            'entry_column' => 'Entry Column'
        ];
    }

    /**
     * Returns the Kanban Columns associated with this board
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColumns() {

        return $this->hasMany(Column::className(), ['board_id' => 'id'])
            ->orderBy('display_order')
            ->all();
    }

    /**
     * Retrieves the current active board ID for this session
     * if not found an error is thrown
     *
     * @throws yii\web\NotFoundHttpException
     * @return \yii\db\ActiveRecord
     */
    public static function getActiveboard() {

        $session = Yii::$app->session;
        $currentBoardId = $session->get('currentBoardId');

        if ($currentBoardId == self::NO_ACTIVE_BOARD_STATUS_TEST) {
            throw new NotFoundHttpException(self::NO_ACTIVE_BOARD_MESSAGE);
        } else {
            Ticket::restrictQueryToBoard($currentBoardId);
            return self::findOne($currentBoardId);
        }
    }

    /**
     * Creates a Demo Board
     *
     * @return $this|null
     */
    public function createDemoBoard() {
        if (YII_ENV_DEMO) {
            $faker = Factory::create();

            $this->deleteAll();
            $this->title = self::DEMO_TITLE;
            $this->max_lanes = self::DEMO_MAX_LANES;
            $this->description = "Description Text: " . $faker->text();
            $this->entry_column = 0; // Temp value until the Demo Columns are created,

            if ($this->save()) {
                return $this;
            }
        }

        return null;
    }

}