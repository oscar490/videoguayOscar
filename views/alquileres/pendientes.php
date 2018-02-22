<?php
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

?>
<?php if (empty($pendientes->all())): ?>
    <h3>No tiene alquileres pendientes</h3>

<?php else: ?>

<h3>Alquileres Pendientes</h3>
<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $pendientes,
        'pagination' => false,
        'sort' => false,
    ]),
    'columns' => [
        'pelicula.codigo',
        'pelicula.titulo',
        'create_at:datetime',
    ],
]); ?>
<?php endif ?>
