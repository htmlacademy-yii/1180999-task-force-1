<?php

namespace frontend\models;

use frontend\models\forms\TaskFilterForm;
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
            'query' => $query,
        ]);

        if (!empty($modelForm->category_ids)) {
            $query->leftJoin('categories', 'category_id = tasks.category_id')
                ->where(['category_id' => $modelForm->category_ids]);
        }

        if ($modelForm->remote) {
            $query->andWhere(['city_id' => null]);
        }

        if ($modelForm->noExecutor == 1) {
            $query->andWhere(['executor_id' => null]);
        }

        if ($modelForm->search) {
            $query->andFilterWhere(['like', 'name', $modelForm->search]);
        }

        if ($modelForm->interval) {
            if ($modelForm->interval == 1) {
                $query->andWhere(['dt_add' => date('Y-m-d')]);
            } elseif ($modelForm->interval == 2) {
                $query->andWhere(['between', 'dt_add', date('Y-m-d', strtotime('-7 days')), date('Y-m-d')]);
            } elseif ($modelForm->interval == 3) {
                $query->andWhere(['between', 'dt_add', date('Y-m-d', strtotime('-1 month')), date('Y-m-d')]);
            }

            $query->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description]);
        }
        return $dataProvider;
    }
}
