<?php

namespace app\commands;

use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Comandos de mantenimiento relacionados con los usuarios.
 */
class UsuariosController extends Controller
{
    /**
     * Elimina los usuarios que llevan más de 48 horas sin
     * validarse.
     */
    public function actionLimpiar()
    {
        $res = Usuarios::deleteAll(
            "token_val IS NOT NULL AND :ahora - create_at >= 'P2D'::interval",
            [
                'ahora' => date('Y-m-d H:i:s'),
            ]
        );

        echo "Se ha eliminado $res usuarios.\n";
        return ExitCode::OK;
    }
}
