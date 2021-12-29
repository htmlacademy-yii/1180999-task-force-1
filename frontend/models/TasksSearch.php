<?php

namespace frontend\models;

use frontend\models\forms\TaskFilterForm;
use taskforce\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TasksSearch represents the model behind the search form of `frontend\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'executor_id', 'category_id', 'city_id', 'cost'], 'integer'],
            [['dt_add', 'deadline', 'status', 'name', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
    public function search(TaskFilterForm $modelForm): ActiveDataProvider
    {
        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'dt_add' => SORT_DESC
                ]
            ],
        ]);

        if (!empty($modelForm->category_ids)) {
            $query->leftJoin('categories', 'categories.id = tasks.category_id')
                ->andWhere([
                    'category_id' => $modelForm->category_ids
                ]);
        }

        if ($modelForm->noResponses) {
            $query->leftJoin('responses', 'responses.task_id = tasks.id')
                ->andWhere('responses.task_id IS NULL');
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
