<?php

namespace frontend\models;

use frontend\models\forms\TaskFilterForm;
use taskforce\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tasks;

/**
 * TasksSearch represents the model behind the search form of `frontend\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'executor_id', 'category_id', 'city_id', 'cost'], 'integer'],
            [['dt_add', 'deadline', 'status', 'name', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param TaskFilterForm $modelForm
     *
     * @return ActiveDataProvider
     */
    public function search(TaskFilterForm $modelForm)
    {
        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!empty($modelForm->category_ids)) {
            $query->leftJoin('categories', 'category_id = tasks.category_id')
                ->where([
                    'category_id' => $modelForm->category_ids
                ]);
        }

        if ($modelForm->noResponses) {
            $query->leftJoin('responses', 'responses.task_id = tasks.id')
                ->Where('responses.task_id IS NULL');
        }

        if ($modelForm->remote) {
            $query->andWhere('location IS NULL');
        }

        $query->andWhere(['status' => Task::STATUS_NEW]);

        if ($modelForm->search) {
            $query->andWhere(['like', 'tasks.name', $modelForm->search]);
        }

        if ($modelForm->interval) {

            switch ($modelForm->interval) {
                case 1:
                    $query->andFilterWhere(['>=', 'tasks.dt_add', date('Y-m-d')]);
                    break;
                case 2:
                    $query->andFilterWhere(['>=', 'tasks.dt_add', date('Y-m-d', strtotime('-1 week'))]);
                    break;
                case 3:
                    $query->andFilterWhere(['>=', 'tasks.dt_add', date('Y-m-d', strtotime('-1 month'))]);
            }
        }

        $query->orderBy('dt_add DESC');

        return $dataProvider;
    }
}
