<?php

/* @var $this yii\web\View */
use app\models\Peliculas;

$this->title = 'VideoGuay';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>¡Bienvenidos al mundo del cine!</h1>

        <p >Disfruta de nuestras novedades.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

    <?php

    $filas = Peliculas::find()->limit(10)->all();

     ?>
     <div class="col-md-offset-3 col-md-6">
         <h3>últimas peliculas</h3>
         <table class='table'>
             <thead>
                 <th>Código</th>
                 <th>Título</th>
                 <th>Precio de alquiler</th>
             </thead>
             <tbody>
                 <?php foreach ($filas as $pelicula): ?>
                     <tr>
                         <td><?= $pelicula->codigo ?></td>
                         <td><?= $pelicula->titulo ?></td>
                         <td><?= $pelicula->precio_alq ?></td>
                     </tr>
                 <?php endforeach ?>
             </tbody>
         </table>
    </div>


        <!-- <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div> -->

    </div>
</div>
