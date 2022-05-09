<?php

/* SEGURIDAD */ {

    function mssql_espape($str)
    {
        $aux = str_replace("'", "", $str);
        $aux = str_replace(";", "", $aux);
        $aux = str_replace("--", "", $aux);
        $aux = str_replace("xp_", "", $aux);
        $aux = str_replace('"', "", $aux);
        return $aux;
    }

    function seguridad($str)
    {
        $aux = str_replace("'", "", $str);
        $aux = str_replace(";", "", $aux);
        $aux = str_replace("--", "", $aux);
        $aux = str_replace("xp_", "", $aux);
        $aux = str_replace('"', "", $aux);
        return $aux;
    }
}

/* SISTEMA */ {

    function get_error($id)
    {
        include 'db.php';
        $error = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM {$sportapp_db}.tb_error WHERE id = '" . $id . "'"));
        return $error;
    }

    function moneda($valor)
    {
        $resultado = number_format($valor, 2, ',', '.');
        return $resultado;
    }

    function error($contenido)
    {
        $resultado = "<script>$.confirm({ theme: 'modern', title: 'Error', content: '" . $contenido . "', type: 'red', typeAnimated: true, buttons: { Ok: { text: 'Ok', btnClass: 'btn-red', action: function(){ } }, Cerrar: function () { } } });</script>";
        return $resultado;
    }

    function insertar_error($error)
    {
        include 'db.php';
        mysqli_query($conexion, "INSERT INTO " . get_db() . ".error (error) VALUES ('" . seguridad($error) . "')");
    }

    function auditoria($categoria, $concepto)
    {
        include 'db.php';
        mysqli_query($conexion, "INSERT INTO " . get_db() . ".auditoria (a_categoria, a_concepto, a_usuario) VALUES ('" . seguridad($categoria) . "', '" . seguridad($concepto) . "', '" . get_id_usuario() . "')");
    }

    function get_listado_auditoria($fecini, $fecfin)
    {
        include 'db.php';
        $inicio = date('Ymd', strtotime($fecini));
        $fin = date('Ymd', strtotime($fecfin));
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.a_fecha, a.a_categoria, a.a_concepto, b.u_usuario FROM " . get_db() . ".auditoria AS a INNER JOIN {$sportapp_db}.tb_usuario AS b ON a.a_usuario = b.id WHERE a.a_fecha BETWEEN '" . $inicio . "' AND '" . $fin . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0]->format('d/m/Y H:i:s') . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            //                $tabla .= "<td>".substr($f[2], 0, 50)."</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function consola($contenido)
    {
        echo '<script>console.log("' . $contenido . '");</script>';
    }

    function modulo_habilitado($modulo)
    {
        include 'db.php';
        $json_modulos = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.c_modulos FROM {$sportapp_db}.tb_club AS a WHERE a.c_db = '" . get_db() . "'"));
        $modulos_habilitados = json_decode($json_modulos[0], true);
        if (in_array($modulo, $modulos_habilitados)) {
            return true;
        } else {
            return false;
        }
    }
}

/* ESTILO */ {

    function color_sidebar()
    {
        include 'db.php';
        $color = mysqli_fetch_array(mysqli_query($conexion, "SELECT e_color_sidebar FROM " . get_db() . ".estilo WHERE id = 1"));
        return $color[0];
    }

    function get_estilo_club()
    {
        include 'db.php';
        $estilo = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".estilo WHERE id = 1"));
        return $estilo;
    }

    function update_color_sidebar($e_color_sidebar)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".estilo SET e_color_sidebar = '" . $e_color_sidebar . "' WHERE id = 1")) {
            return true;
        } else {
            return false;
        }
    }
}

/* USUARIO */ {

    function get_nombre_usuario()
    {
        include 'db.php';
        $nombre = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.u_nombre FROM {$sportapp_db}.tb_usuario AS a WHERE a.u_usuario = '" . get_usuario() . "'"));
        return $nombre[0];
    }

    function get_token($usuario)
    {
        include 'db.php';
        $sql = "SELECT a.u_token FROM {$sportapp_db}.tb_usuario AS a WHERE a.u_usuario = '" . $usuario . "'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

    function set_token($usuario)
    {
        include 'db.php';
        $length = 50;
        $token = bin2hex(random_bytes($length));
        mysqli_query($conexion, "UPDATE {$sportapp_db}.tb_usuario SET u_token = '" . $token . "' WHERE u_usuario = '" . $usuario . "'");
        $_SESSION['SVCGE_TOKEN'] = $token;
    }

    function get_login($usuario, $password)
    {
        include 'db.php';
        $sql = "SELECT COUNT(a.id) FROM {$sportapp_db}.tb_usuario AS a WHERE a.u_usuario = '" . $usuario . "' AND a.u_password = '" . md5($password) . "' AND a.u_estado = 'HABILITADO'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

    function get_db_usuario($usuario)
    {
        include 'db.php';
        $sql = "SELECT b.c_db FROM {$sportapp_db}.tb_usuario AS a INNER JOIN {$sportapp_db}.tb_club AS b ON a.u_club = b.id WHERE a.u_usuario = '" . $usuario . "' AND a.u_estado = 'HABILITADO'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

    function get_usuario()
    {
        return $_COOKIE['SP_USER'];
    }

    function get_id_usuario()
    {
        include 'db.php';
        $id = mysqli_fetch_array(mysqli_query($conexion, "SELECT id FROM {$sportapp_db}.tb_usuario WHERE u_usuario = '" . get_usuario() . "'"));
        return $id[0];
    }
}

/* CLUB */ {

    function get_nombre_club()
    {
        include 'db.php';
        $nombre = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_nombre FROM " . get_db() . ".club WHERE id = 1"));

        return $nombre[0];
    }

    function get_logo()
    {
        include 'db.php';
//        var_dump(get_db());die;
//        var_dump("SELECT a.c_icon_mime, a.c_icon_data, a.c_logo_mime, a.c_logo_data FROM " . get_db() . ".club AS a WHERE a.id = 1");die;
        $logo = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.c_icon_mime, a.c_icon_data, a.c_logo_mime, a.c_logo_data FROM " . get_db() . ".club AS a WHERE a.id = 1"));
        return $logo;
    }

    function get_db()
    {
        return $_COOKIE['SP_DB'];
    }

    function get_coordenadas_club()
    {
        include 'db.php';
        $coordenadas = mysqli_fetch_array(mysqli_query($conexion, "SELECT CAST(a.c_latitud AS varchar) + ', ' + CAST(a.c_longitud AS varchar) FROM " . get_db() . ".club AS a WHERE a.id = 1"));
        return $coordenadas[0];
    }

    function get_info_club()
    {
        include 'db.php';
        $club = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".club WHERE id = 1"));
        return $club;
    }
}

/* FORMAS DE PAGO */ {
    function get_select_forpag($forpag)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, forpag_nombre FROM " . get_db() . ".forpag ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($forpag != 0) {
                if ($forpag == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }

    function get_select_forpag_lote($forpag)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, forpag_nombre FROM " . get_db() . ".forpag WHERE forpag_debito = 'S' ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($forpag != 0) {
                if ($forpag == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* FRECUENCIAS DE PAGO */ {

    function get_select_frepag($frepag)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, frepag_nombre FROM " . get_db() . ".frepag ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($frepag != 0) {
                if ($frepag == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }

    function get_frepag_periodo($periodo)
    {
        $mes = date('m', strtotime($periodo));

        $condicion = "";

        if ($mes == 1) {
            $condicion = "(1,2,3,4,5)";
        }
        if ($mes == 2) {
            $condicion = "(1)";
        }
        if ($mes == 3) {
            $condicion = "(1,2)";
        }
        if ($mes == 4) {
            $condicion = "(1,3)";
        }
        if ($mes == 5) {
            $condicion = "(1,2)";
        }
        if ($mes == 6) {
            $condicion = "(1)";
        }
        if ($mes == 7) {
            $condicion = "(1,2,3,4)";
        }
        if ($mes == 8) {
            $condicion = "(1)";
        }
        if ($mes == 9) {
            $condicion = "(1,2)";
        }
        if ($mes == 10) {
            $condicion = "(1,3)";
        }
        if ($mes == 11) {
            $condicion = "(1,2)";
        }
        if ($mes == 12) {
            $condicion = "(1)";
        }

        return $condicion;
    }

    function get_colspan_cuota_socio($frepag)
    {
        $colspan = 0;
        if ($frepag == 1) {
            $colspan = 1;
        }
        if ($frepag == 2) {
            $colspan = 2;
        }
        if ($frepag == 3) {
            $colspan = 3;
        }
        if ($frepag == 4) {
            $colspan = 6;
        }
        if ($frepag == 5) {
            $colspan = 12;
        }

        return $colspan;
    }
}

/* TARJETAS */ {

    function get_select_tarjetas($tarjeta)
    {
        include 'db.php';
        $base = get_db();
        // $sql = "SELECT id, t_nombre, t_forpag FROM " . get_db() . ".tarjeta ORDER BY id ASC";
        $sql = "SELECT id, t_nombre, t_forpag FROM " . get_db() . ".tarjeta WHERE t_estado = 'HABILITADO' ORDER BY id ASC";

        
        $options = "";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $options .= "<option class='" . $f[2] . "'" . ($tarjeta != 0 && $tarjeta == $f[0] ? " selected" : "") . " value='" . $f[0] . "'>" . $f[1] . "</option>";
/*
            if ($tarjeta != 0) {
                if ($tarjeta == $f[0]) {
                    $options .= "<option class='" . $f[2] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[2] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[2] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
*/
        }
        return $options;
    }

    function get_select_tarjetas_lote($tarjeta)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, t_nombre FROM " . get_db() . ".tarjeta WHERE id NOT IN (1) ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($tarjeta != 0) {
                if ($tarjeta == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* BECAS */ {

    function insert_beca($b_nombre, $b_porcentaje)
    {
        include 'db.php';
        if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".beca (b_nombre, b_porcentaje) VALUES ('" . strtoupper(mssql_espape($b_nombre)) . "', '" . $b_porcentaje . "')")) {
            auditoria("BECA", "NUEVA BECA. NOMBRE: " . $b_nombre . ". PORCENTAJE: " . $b_porcentaje);
            return true;
        } else {
            return false;
        }
    }

    function get_beca($id)
    {
        include 'db.php';
        $beca = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".beca WHERE id = '" . $id . "'"));
        return $beca;
    }

    function update_beca($id, $b_nombre, $b_porcentaje, $b_estado)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".beca SET b_nombre = '" . mssql_espape(strtoupper($b_nombre)) . "', b_porcentaje = '" . $b_porcentaje . "', b_estado = '" . $b_estado . "' WHERE id = '" . $id . "'")) {
            auditoria("BECA", "UPDATE BECA: " . $b_nombre . ". PORCENTAJE: " . $b_porcentaje . ". ESTADO: " . $b_estado . ". ID: " . $id);
            return true;
        } else {
            return false;
        }
    }

    function get_select_becas($beca)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, b_nombre FROM " . get_db() . ".beca ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($beca != 0) {
                if ($beca == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }

    function get_porcentaje_beca($id)
    {
        include 'db.php';
        $porcentaje = mysqli_fetch_array(mysqli_query($conexion, "SELECT b_porcentaje FROM " . get_db() . ".beca WHERE id = '" . $id . "'"));
        return $porcentaje[0];
    }
}

/* CONVENIOS */ {

    function insert_convenio($c_nombre, $c_monto)
    {
        include 'db.php';
        if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".convenio (c_nombre, c_monto) VALUES ('" . strtoupper(mssql_espape($c_nombre)) . "', '" . $c_monto . "')")) {
            auditoria('CONVENIO', 'NUEVO CONVENIO. NOMBRE: ' . $c_nombre . '. MONTO: ' . $c_monto);
            return true;
        } else {
            return false;
        }
    }

    function get_convenio($id)
    {
        include 'db.php';
        $convenio = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".convenio WHERE id = '" . $id . "'"));
        return $convenio;
    }

    function update_convenio($id, $c_nombre, $c_monto, $c_estado)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".convenio SET c_nombre = '" . mssql_espape(strtoupper($c_nombre)) . "', c_monto = '" . $c_monto . "', c_estado = '" . $c_estado . "' WHERE id = '" . $id . "'")) {
            auditoria('CONVENIO', 'UPDATE CONVENIO. NOMBRE: ' . $c_nombre . '. MONTO: ' . $c_monto . '. ESTADO: ' . $c_estado . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function get_select_convenios($convenio)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, c_nombre FROM " . get_db() . ".convenio ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($convenio != 0) {
                if ($convenio == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }

    function get_monto_convenio($id)
    {
        include 'db.php';
        $monto = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_monto FROM " . get_db() . ".convenio WHERE id = '" . $id . "'"));
        return $monto[0];
    }
}

/* CATEGORIAS */ {

    function get_listado_categorias()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT id, c_nombre FROM " . get_db() . ".categoria ORDER BY c_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td><a class='btn btn-sm btn-primary' href='categoria_editar.php?id=" . $f[0] . "'><i class='fas fa-edit'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function insert_categoria($c_nombre, $c_descripcion)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".categoria (c_nombre, c_descripcion) VALUES ('" . mssql_espape(strtoupper($c_nombre)) . "', '" . mssql_espape($c_descripcion) . "')";
        if (mysqli_query($conexion, $sql)) {
            auditoria('CATEGORIA', 'NUEVA CATEGORIA. NOMBRE: ' . $c_nombre . '. DESCRIPCION: ' . $c_descripcion);
            return true;
        } else {
            return false;
        }
    }

    function get_categoria($id)
    {
        include 'db.php';
        $categoria = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".categoria WHERE id = '" . $id . "'"));
        return $categoria;
    }

    function editar_categoria($id, $c_nombre, $c_descripcion)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".categoria SET c_nombre = '" . mssql_espape(strtoupper($c_nombre)) . "', c_descripcion = '" . mssql_espape($c_descripcion) . "' WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            auditoria('CATEGORIA', 'UPDATE CATEGORIA. NOMBRE: ' . $c_nombre . '. DESCRIPCION: ' . $c_descripcion . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function get_select_categorias($categoria)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, c_nombre FROM " . get_db() . ".categoria ORDER BY c_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($categoria != 0) {
                if ($categoria == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* SUBCATEGORIAS */ {

    function get_subcategoria($id)
    {
        include 'db.php';
        $subcategoria = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".subcategoria WHERE id = '" . $id . "'"));
        return $subcategoria;
    }

    function get_listado_subcategorias()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.sc_nombre, a.sc_mensual, a.sc_bimestral, a.sc_trimestral, a.sc_semestral, a.sc_anual, a.sc_antiguedad, b.c_nombre FROM " . get_db() . ".subcategoria AS a INNER JOIN " . get_db() . ".categoria AS b ON a.sc_categoria = b.id");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[8] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>$ " . moneda($f[2]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[3]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[4]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[5]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[6]) . "</td>";
            $tabla .= "<td>" . $f[7] . "</td>";
            $tabla .= "<td><a href='subcategorias_editar.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-edit'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function insert_subcategoria($sc_categoria, $sc_nombre, $sc_descripcion, $sc_edadini, $sc_edadfin, $sc_antiguedad, $sc_grupofliar, $sc_proxima, $sc_mensual, $sc_bimestral, $sc_trimestral, $sc_semestral, $sc_anual)
    {
        include 'db.php';
        if ($sc_proxima == "NINGUNA") {
            $proxima = 'NULL';
        } else {
            $proxima = "'" . $sc_proxima . "'";
        }
        $sql = "INSERT INTO " . get_db() . ".subcategoria (sc_categoria, sc_nombre, sc_descripcion, sc_edadini, sc_edadfin, sc_antiguedad, sc_grupofliar, sc_proxima, sc_mensual, sc_bimestral, sc_trimestral, sc_semestral, sc_anual) VALUES ('" . $sc_categoria . "', '" . mssql_espape(strtoupper($sc_nombre)) . "', '" . mssql_espape($sc_descripcion) . "', '" . $sc_edadini . "', '" . $sc_edadfin . "', '" . $sc_antiguedad . "', '" . $sc_grupofliar . "', $proxima, '" . $sc_mensual . "', '" . $sc_bimestral . "', '" . $sc_trimestral . "', '" . $sc_semestral . "', '" . $sc_anual . "')";
        if (mysqli_query($conexion, $sql)) {
            auditoria('SUBCATEGORIA', 'NUEVA SUBCATEGORIA. CATEGORIA: ' . $sc_categoria . '. NOMBRE: ' . $sc_nombre . '. DESCRIPCION: ' . $sc_descripcion . '. EDAD INICIO: ' . $sc_edadini . '. EDAD FIN: ' . $sc_edadfin . '. ANTIGUEDAD: ' . $sc_antiguedad . '. PROXIMA CATEGORIA: ' . $sc_proxima . '. MENSUAL: ' . $sc_mensual . '. BIMESTRAL: ' . $sc_bimestral . '. TRIMESTRAL: ' . $sc_trimestral . '. SEMESTRAL: ' . $sc_semestral . '. ANUAL: ' . $sc_anual);
            return true;
        } else {
            return false;
        }
    }

    function editar_subcategoria($id, $sc_categoria, $sc_nombre, $sc_descripcion, $sc_edadini, $sc_edadfin, $sc_antiguedad, $sc_grupofliar, $sc_proxima, $sc_mensual, $sc_bimestral, $sc_trimestral, $sc_semestral, $sc_anual)
    {
        include 'db.php';
        if ($sc_proxima == "NINGUNA") {
            $proxima = 'NULL';
        } else {
            $proxima = "'" . $sc_proxima . "'";
        }
        $sql = "UPDATE " . get_db() . ".subcategoria SET sc_categoria = '" . $sc_categoria . "', sc_nombre = '" . mssql_espape(strtoupper($sc_nombre)) . "', sc_descripcion = '" . mssql_espape($sc_descripcion) . "', sc_edadini = '" . $sc_edadini . "', sc_edadfin = '" . $sc_edadfin . "', sc_antiguedad = '" . $sc_antiguedad . "', sc_grupofliar = '" . $sc_grupofliar . "', sc_proxima = " . $proxima . ", sc_mensual = '" . $sc_mensual . "', sc_bimestral = '" . $sc_bimestral . "', sc_trimestral = '" . $sc_trimestral . "', sc_semestral = '" . $sc_semestral . "', sc_anual = '" . $sc_anual . "' WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            auditoria('SUBCATEGORIA', 'UPDATE SUBCATEGORIA. CATEGORIA: ' . $sc_categoria . '. NOMBRE: ' . $sc_nombre . '. DESCRIPCION: ' . $sc_descripcion . '. EDAD INICIO: ' . $sc_edadini . '. EDAD FIN: ' . $sc_edadfin . '. ANTIGUEDAD: ' . $sc_antiguedad . '. PROXIMA CATEGORIA: ' . $sc_proxima . '. MENSUAL: ' . $sc_mensual . '. BIMESTRAL: ' . $sc_bimestral . '. TRIMESTRAL: ' . $sc_trimestral . '. SEMESTRAL: ' . $sc_semestral . '. ANUAL: ' . $sc_anual . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function get_select_subcategorias($subcategoria)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, sc_nombre, sc_categoria FROM " . get_db() . ".subcategoria ORDER BY sc_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($subcategoria != 0) {
                if ($subcategoria == $f[0]) {
                    $options .= "<option class='" . $f[2] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[2] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[2] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* PERIODOS */ {

    function get_listado_periodos()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.p_periodo, count(a.p_subcategoria) FROM " . get_db() . ".periodo AS a GROUP BY a.p_periodo");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td style='display:none;'>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td><a href='periodos_info.php?periodo=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function generar_periodo($periodo)
    {
        include 'db.php';
        $mes = date('Y-m-01', strtotime($periodo));
        if (check_periodo($mes)) {
            $r_subcategoria = mysqli_query($conexion, "SELECT id, sc_mensual, sc_bimestral, sc_trimestral, sc_semestral, sc_anual FROM " . get_db() . ".subcategoria WHERE sc_estado = 'HABILITADO' ORDER BY sc_nombre ASC");
            while ($f_subcategoria = mysqli_fetch_array($r_subcategoria)) {
                mysqli_query($conexion, "INSERT INTO " . get_db() . ".periodo (p_periodo, p_subcategoria, p_mensual, p_bimestral, p_trimestral, p_semestral, p_anual) VALUES ('" . $mes . "', '" . $f_subcategoria[0] . "', '" . $f_subcategoria[1] . "', '" . $f_subcategoria[2] . "', '" . $f_subcategoria[3] . "', '" . $f_subcategoria[4] . "', '" . $f_subcategoria[5] . "')");
                auditoria('PERIODO', 'NUEVO PERIODO. PERIODO: ' . $mes . '. SUBCATEGORIA: ' . $f_subcategoria[0] . '. MENSUAL: ' . $f_subcategoria[1] . '. BIMESTRAL: ' . $f_subcategoria[2] . '. TRIMESTRAL: ' . $f_subcategoria[3] . '. SEMESTRAL: ' . $f_subcategoria[4] . '. ANUAL: ' . $f_subcategoria[5]);
            }
            return true;
        } else {
            return false;
        }
    }

    function check_periodo($mes)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(p_periodo) FROM " . get_db() . ".periodo WHERE p_periodo = '" . $mes . "'"));
        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_existencia_periodo($periodo)
    {
        include 'db.php';
        $cuenta_periodo = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".periodo WHERE p_periodo = '" . $periodo . "'"));
        $cuenta_subcategorias = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".subcategoria WHERE sc_estado = 'HABILITADO'"));
        if ($cuenta_periodo[0] == $cuenta_subcategorias[0]) {
            return true;
        } else {
            return false;
        }
    }

    function get_listado_categorias_periodo($periodo)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.c_nombre, b.sc_nombre, a.p_mensual, a.p_bimestral, a.p_trimestral, a.p_semestral, a.p_anual FROM " . get_db() . ".periodo AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.p_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id WHERE a.p_periodo = '" . $periodo . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>$ " . moneda($f[3]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[4]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[5]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[6]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[7]) . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_select_periodos()
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT CAST(p_periodo AS date) FROM " . get_db() . ".periodo GROUP BY p_periodo ORDER BY p_periodo DESC");
        while ($f = mysqli_fetch_array($r)) {
            $options .= "<option value='" . $f[0] . "'>" . $f[0]->format('m/Y') . "</option>";
        }
        return $options;
    }

    function check_cuota_futura($c_periodo, $c_sc)
    {
        include 'db.php';
        $cuenta = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".periodo WHERE p_periodo = '" . $c_periodo . "' AND p_subcategoria = '" . $c_sc . "'"));
        if ($cuenta[0] == 0) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
}

/* SEXOS */ {

    function get_select_sexos($sexo)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, s_nombre FROM " . get_db() . ".sexo ORDER BY s_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($sexo != 0) {
                if ($sexo == $f[0]) {
                    $options .= "<option selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* SOCIOS */ {

    function get_socnro_alta($s_documento)
    {
        include 'db.php';
        $id = mysqli_fetch_array(mysqli_query($conexion, "SELECT id FROM " . get_db() . ".socio WHERE s_documento = '" . $s_documento . "'"));
        return $id[0];
    }

    function get_info_socio($id)
    {
        include 'db.php';
        $socio = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio WHERE id = '" . $id . "'"));
        return $socio;
    }

    function get_estado_socio($id)
    {
        include 'db.php';
        $estado = mysqli_fetch_array(mysqli_query($conexion, "SELECT b.e_nombre FROM " . get_db() . ".socio AS a INNER JOIN " . get_db() . ".estado AS b ON a.s_estado = b.id WHERE a.id = '" . $id . "'"));
        $estilo = "";
        if ($estado[0] == 'ALTA') {
            $estilo = "success";
        } else {
            $estilo = "danger";
        }
        array_push($estado, $estilo);
        return $estado;
    }

    function get_lista_socios()
    {
        include 'db.php';
        $data = array();
        $sql = "SELECT a.id, a.s_apellido, a.s_nombre, a.s_documento, a.s_fecnac, a.s_fecing, b.e_nombre FROM " . get_db() . ".socio AS a INNER JOIN " . get_db() . ".estado AS b ON a.s_estado = b.id";
        $r = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($r)) {
            array_push($data, $fila);
        }
        return $data;
    }

    function alta_socio($s_apellido, $s_nombre, $s_documento, $s_fecnac, $s_telefono, $s_celular, $s_email, $s_sexo, $s_domicilio, $s_latitud, $s_longitud)
    {
        include 'db.php';
        if (check_socio($s_documento)) {
            if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".socio (s_apellido, s_nombre, s_documento, s_fecnac, s_telefono, s_celular, s_email, s_sexo, s_domicilio, s_latitud, s_longitud) VALUES ('" . mssql_espape(strtoupper($s_apellido)) . "', '" . mssql_espape(strtoupper($s_nombre)) . "', '" . $s_documento . "', '" . $s_fecnac . "', '" . $s_telefono . "', '" . $s_celular . "', '" . strtolower($s_email) . "', '" . $s_sexo . "', '" . $s_domicilio . "', '" . $s_latitud . "', '" . $s_longitud . "')")) {
                auditoria('SOCIO', 'NUEVO SOCIO. NOMBRE: ' . $s_apellido . ', ' . $s_nombre . '. DOCUMENTO: ' . $s_documento . '. FEC NACIMIENTO: ' . $s_fecnac . '. TELEFONO: ' . $s_telefono . '. CELULAR: ' . $s_celular . '. EMAIL: ' . $s_email . '. SEXO: ' . $s_sexo . '. DOMICILIO: ' . $s_domicilio . '. LATITUD: ' . $s_latitud . '. LONGITUD: ' . $s_longitud);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

   /*****************************************************************************************/
   /******************************Carga de Excel de Socios ***********************/
   /****************************************************************************************/
    function alta_socio_excel($id, $s_apellido, $s_nombre, $s_documento, $s_fecnac,$s_fecing ,$s_telefono, $s_celular, $s_email, $s_sexo, $s_domicilio, $s_estado,$meses_adeudados,$s_latitud, $s_longitud)
    {

       /* $sql ="INSERT INTO " . get_db() . ".socio (id, s_apellido, s_nombre, s_documento, s_fecnac, s_telefono, s_celular, s_email, s_sexo, s_domicilio, s_estado, meses_adeudados, s_latitud, s_longitud) VALUES ('" . $id . "','" . mssql_espape(strtoupper($s_apellido)) . "', '" . mssql_espape(strtoupper($s_nombre)) . "', '" . $s_documento . "', '" . $s_fecnac . "', '" . $s_fecing . "', '" . $s_telefono . "', '" . $s_celular . "', '" . strtolower($s_email) . "', '" . $s_sexo . "', '" . $s_domicilio . "', '" . $s_estado . "','" . $meses_adeudados . "','" . $s_latitud . "', '" . $s_longitud . "')";*/

        //var_dump( $sql);
        //exit;

        include 'db.php';
        if (check_socio($s_documento)) {
            if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".socio (id, s_apellido, s_nombre, s_documento, s_fecnac, s_fecing, s_telefono, s_celular, s_email, s_sexo, s_domicilio, s_estado, meses_adeudados, s_latitud, s_longitud) VALUES ('" . $id . "','" . mssql_espape(strtoupper($s_apellido)) . "', '" . mssql_espape(strtoupper($s_nombre)) . "', '" . $s_documento . "', '" . $s_fecnac . "', '" . $s_fecing . "', '" . $s_telefono . "', '" . $s_celular . "', '" . strtolower($s_email) . "', '" . $s_sexo . "', '" . $s_domicilio . "', '" . $s_estado . "','" . $meses_adeudados . "','" . $s_latitud . "', '" . $s_longitud . "')")) {
                auditoria('SOCIO', 'NUEVO SOCIO. NOMBRE: ' . $s_apellido . ', ' . $s_nombre . '. DOCUMENTO: ' . $s_documento . '. FEC NACIMIENTO: ' . $s_fecnac . '. TELEFONO: ' . $s_telefono . '. CELULAR: ' . $s_celular . '. EMAIL: ' . $s_email . '. SEXO: ' . $s_sexo . '. DOMICILIO: ' . $s_domicilio . '. LATITUD: ' . $s_latitud . '. LONGITUD: ' . $s_longitud);
                

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
   
    
   /*****************************************************************************************/
   /******************************Actualizacion de Socios con Excel ***********************/
   /****************************************************************************************/

   function update_estado_($id, $estado, $s_telefono, $s_celular, $meses_adeudados)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".socio SET s_estado = '" . $estado . "', s_telefono = '" . $s_telefono . "', s_celular = '" . $s_celular . "', meses_adeudados = '" . $meses_adeudados . "'  WHERE id = '" . $id . "'")) {
            return true;
        } else {
            return false;
        }
    }

   /**********************************************************************************************/

    function check_socio($s_documento)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio WHERE s_documento = '" . $s_documento . "'"));

        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*********************************************************************************************************/

     function check_socio_nro($socio)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio WHERE id = '" . $socio . "'"));

        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*********************************************************************************************************/


    // function check_carnet($s_carnet)
    // {
    //     include 'db.php';
    //     $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio WHERE s_documento = '" . $s_carnet . "'"));
    //     if ($count[0] == 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    function check_img_socio($id)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".imagen WHERE i_socio = '" . $id . "'"));
        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_img_socio($id)
    {
        include 'db.php';
        $img = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".imagen WHERE i_socio = '" . $id . "' ORDER BY id DESC LIMIT 0,1"));
        return $img;
    }

    function get_edad_socio($id)
    {
        include 'db.php';
        $socio = mysqli_fetch_array(mysqli_query($conexion, "SELECT s_fecnac FROM " . get_db() . ".socio WHERE id = '" . $id . "'"));
        $edad = floor((time() - strtotime($socio[0])) / 31556926);
        return $edad;
    }

    function update_domicilio_socio($id, $s_domicilio, $s_latitud, $s_longitud)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".socio SET s_domicilio = '" . $s_domicilio . "', s_latitud = '" . $s_latitud . "', s_longitud = '" . $s_longitud . "' WHERE id = '" . $id . "'")) {
            auditoria('SOCIO', 'UPDATE SOCIO-DOMICILIO. DOMICILIO: ' . $s_domicilio . '. LATITUD: ' . $s_latitud . '. LONGITUD: ' . $s_longitud . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function update_datos_socio($id, $s_apellido, $s_nombre, $s_documento, $s_fecnac, $s_sexo)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".socio SET s_apellido = '" . $s_apellido . "', s_nombre = '" . $s_nombre . "', s_documento = '" . $s_documento . "', s_fecnac = '" . $s_fecnac . "', s_sexo = '" . $s_sexo . "' WHERE id = '" . $id . "'")) {
            auditoria('SOCIO', 'UPDATE SOCIO-DATOS. NOMBRE: ' . $s_apellido . ', ' . $s_nombre . '. DOCUMENTO: ' . $s_documento . '. FEC NACIMIENTO: ' . $s_fecnac . '. SEXO: ' . $s_sexo . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function update_contacto_socio($id, $s_telefono, $s_celular, $s_email)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".socio SET s_telefono = '" . $s_telefono . "', s_celular = '" . $s_celular . "', s_email = '" . $s_email . "' WHERE id = '" . $id . "'")) {
            auditoria('SOCIO', 'UPDATE SOCIO-CONTACTO. TELEFONO: ' . $s_telefono . '. CELULAR: ' . $s_celular . '. EMAIL: ' . $s_email . '. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }


   

    function get_resultados_busqueda_socio($campo)
    {
        include 'db.php';
        $sql = "";
        if (is_numeric(seguridad($campo))) {
            $sql = "SELECT a.id, a.s_apellido, a.s_nombre, a.s_documento, a.s_fecnac, b.e_nombre FROM " . get_db() . ".socio AS a INNER JOIN " . get_db() . ".estado AS b ON a.s_estado = b.id WHERE a.s_documento = '" . seguridad($campo) . "'";
        } else {
            $sql = "SELECT a.id, a.s_apellido, a.s_nombre, a.s_documento, a.s_fecnac, b.e_nombre FROM " . get_db() . ".socio AS a INNER JOIN " . get_db() . ".estado AS b ON a.s_estado = b.id WHERE a.s_apellido LIKE '%" . seguridad($campo) . "%'";
        }

        $tabla = "";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td><a href='socio_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_select_socios($socio)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, CONCAT(s_apellido, ', ', s_nombre, ' - ', s_documento) FROM " . get_db() . ".socio ORDER BY s_apellido, s_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($socio != 0) {
                if ($socio == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* CUOTAS */ {

    function insert_cuota_socio($fecha, $socio_categoria, $referencia_monto)
    {
        include 'db.php';
        //TRANSFORMA LA FECHA INGRESADA EN YYYY-MM-01
        $c_periodo = date('Y-m-01', strtotime($fecha));
        //SELECCIONA LOS DATOS PARA GENERAR LA CUOTA
        $subcategoria = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio_categoria WHERE id = '" . $socio_categoria . "'"));
        $c_socio = $subcategoria['sc_socio'];
        $c_sc = $socio_categoria;
        $c_subcategoria = $subcategoria['sc_subcategoria'];
        $c_forpag = $subcategoria['sc_forpag'];
        $c_frepag = $subcategoria['sc_frepag'];
        $c_beca = $subcategoria['sc_beca'];
        $c_convenio = $subcategoria['sc_convenio'];

        if (check_cuota_socio($c_periodo, $c_sc)) { //SI NO EXISTE UNA CUOTA CON EL MISMO PERIODO Y EL MISMO SOCIO_CATEGORIA

            //GET DEL ULTIMO PERIODO CON SU FRECUENCIA DE PAGO
            $ult_periodo = get_ultimo_periodo_actividad($c_periodo, $c_sc);

            //TRANSFORMO EL ULTIMO PERIODO EN MES (INTEGER)
            $ult_mes = date('m', strtotime($ult_periodo[0]));
            //DEPENDIENDO DE SU FRECUENCIA DE PAGO LE SUMO SU RESPECTIVA CANT DE MESES
            if ($c_frepag != $ult_periodo[1]) {
                if ($ult_periodo[1] == 1) {
                    $ult_mes = $ult_mes + 1;
                }
                if ($ult_periodo[1] == 2) {
                    $ult_mes = $ult_mes + 2;
                }
                if ($ult_periodo[1] == 3) {
                    $ult_mes = $ult_mes + 3;
                }
                if ($ult_periodo[1] == 4) {
                    $ult_mes = $ult_mes + 6;
                }
                if ($ult_periodo[1] == 5) {
                    $ult_mes = $ult_mes + 12;
                }
            } else {
                $ult_mes = 0;
            }
            //TRANSFORMA EL PERIODO EN GENERAR A INTEGER MES
            $mes_presente = date('m', strtotime($c_periodo));

            //CONDICION SI LA CUOTA ANTERIOR NO EXISTE
            $test_cuota_anterior = date('Y', strtotime($ult_periodo[0]));
            if ($test_cuota_anterior == 1900) {
                $ult_mes = 0;
            }

            //SI LA ULTIMA CUOTA (SUMANDO SU FRECUENCIA DE PAGO) ES MENOR O IGUAL A EL PERIODO A GENERAR
            if ($ult_mes <= $mes_presente) {
                if (cuota_periodo_frepag($c_periodo, $c_frepag)) { //SI EL MES DEL PERIODO A GENERAR CORRESPONDE A SU FRECUENCIA DE PAGO
                    //INICIALIZO EN 0 AL MONTO
                    $c_monto = 0;
                    //DEL FORMULARIO POST SI TOMA LA REFERENCIA DE MONTO EL PERIODO ACTUAL O ANTERIOR
                    if ($referencia_monto == 'ACTUAL') {
                        $m = mysqli_fetch_array(mysqli_query($conexion, "SELECT CASE WHEN " . $c_frepag . " = 1 THEN sc_mensual WHEN " . $c_frepag . " = 2 THEN sc_bimestral WHEN " . $c_frepag . " = 3 THEN sc_trimestral WHEN " . $c_frepag . " = 4 THEN sc_semestral ELSE sc_anual END FROM " . get_db() . ".subcategoria WHERE id = '" . $subcategoria['sc_subcategoria'] . "'"));
                        $c_monto = $m[0];
                    }
                    if ($referencia_monto == 'PERIODO') {
                        $m = mysqli_fetch_array(mysqli_query($conexion, "SELECT CASE WHEN " . $c_frepag . " = 1 THEN p_mensual WHEN " . $c_frepag . " = 2 THEN p_bimestral WHEN " . $c_frepag . " = 3 THEN p_trimestral WHEN " . $c_frepag . " = 4 THEN p_semestral ELSE p_anual END FROM " . get_db() . ".periodo WHERE p_subcategoria = '" . $subcategoria['sc_subcategoria'] . "' AND p_periodo = '" . $c_periodo . "'"));
                        $c_monto = $m[0];
                    }
                    //OBTENGO EL PORCENTAJE DE BECA Y EL MONTO DEL CONVENIO
                    $porcentaje_beca = get_porcentaje_beca($c_beca);
                    $monto_convenio = get_monto_convenio($c_convenio);
                    //GENERO EL MONTO DE LA BECA
                    $monto_beca = $c_monto * $porcentaje_beca;
                    //OBTENGO EL NETO A PAGAR DEL SOCIO
                    $aux_total = $c_monto - ($monto_beca + $monto_convenio);

                    $cuota_monto = 0;
                    //SI EL VALOR OBTENIDO ES MENOR A CERO, DECLARO COMO $0 EL VALOR DE LA CUOTA
                    if ($aux_total < 0) {
                        $cuota_monto = 0;
                    } else {
                        $cuota_monto = round($aux_total, 2); //REDONDEO A DOS DECIMALES EL VALOR DE LA CUOTA
                    }

                    $cuota_futura = check_cuota_futura($c_periodo, $c_sc);

                    //INSERTO CUOTA
                    mysqli_query($conexion, "INSERT INTO " . get_db() . ".cuota (c_periodo, c_socio, c_sc, c_subcategoria, c_forpag, c_frepag, c_beca, c_convenio, c_monto, c_futura) VALUES ('" . $c_periodo . "', '" . $c_socio . "', '" . $c_sc . "', '" . $c_subcategoria . "', '" . $c_forpag . "', '" . $c_frepag . "', '" . $c_beca . "', '" . $c_convenio . "', '" . $cuota_monto . "', '" . $cuota_futura . "')");

                    auditoria('CUOTA', 'NUEVA CUOTA. PERIODO: ' . $c_periodo . '. SOCIO: ' . $c_socio . '. SOCIO-CATEGORIA: ' . $c_sc . '. SUBCATEGORIA: ' . $c_subcategoria . '. FORPAG: ' . $c_forpag . '. FREPAG: ' . $c_frepag . '. BECA: ' . $c_beca . '. COVENIO: ' . $c_convenio . '. MONTO: ' . $c_monto);

                    return true;
                } else {
                    insertar_error('EL PERIODO NO CORRESPONDE A SU FRECUENCIA DE PAGO');
                    return false;
                }
            } else {
                insertar_error('EL PERIODO SE VA A PISAR');
                return false;
            }
        } else {
            insertar_error('LA CUOTA YA EXISTE');
            return false;
        }
    }

    function insert_cuota($c_periodo, $c_socio, $c_sc, $c_forpag, $c_frepag, $c_beca, $c_convenio, $c_monto, $c_subcategoria)
    {
        include 'db.php';
        $periodo = date('Y-m-01', strtotime($c_periodo));
        $c_periodo = $periodo;
        if (check_cuota_socio($c_periodo, $c_sc)) {
            if (cuota_periodo_frepag($c_periodo, $c_frepag)) {
                $porcentaje_beca = get_porcentaje_beca($c_beca);
                $monto_convenio = get_monto_convenio($c_convenio);

                $monto_beca = $c_monto * $porcentaje_beca;

                $aux_total = $c_monto - ($monto_beca + $monto_convenio);

                $cuota_monto = 0;

                if ($aux_total < 0) {
                    $cuota_monto = 0;
                } else {
                    $cuota_monto = round($aux_total, 2);
                }

                mysqli_query($conexion, "INSERT INTO " . get_db() . ".cuota (c_periodo, c_socio, c_sc, c_subcategoria, c_forpag, c_frepag, c_beca, c_convenio, c_monto) VALUES ('" . $c_periodo . "', '" . $c_socio . "', '" . $c_sc . "', '" . $c_subcategoria . "', '" . $c_forpag . "', '" . $c_frepag . "', '" . $c_beca . "', '" . $c_convenio . "', '" . $cuota_monto . "')");

                auditoria('CUOTA', 'NUEVA CUOTA. PERIODO: ' . $c_periodo . '. SOCIO: ' . $c_socio . '. SOCIO-CATEGORIA: ' . $c_sc . '. FORPAG: ' . $c_forpag . '. FREPAG: ' . $c_frepag . '. BECA: ' . $c_beca . '. COVENIO: ' . $c_convenio . '. MONTO: ' . $c_monto);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function cuota_periodo_frepag($periodo, $frepag)
    {
        $mes = date('m', strtotime($periodo));
        if ($frepag == 1) {
            return true;
        }

        if ($frepag == 2) {
            $meses = array(1, 3, 5, 7, 9, 11);
            if (in_array($mes, $meses)) {
                return true;
            } else {
                return false;
            }
        }

        if ($frepag == 3) {
            $meses = array(1, 4, 7, 10);
            if (in_array($mes, $meses)) {
                return true;
            } else {
                return false;
            }
        }

        if ($frepag == 4) {
            $meses = array(1, 7);
            if (in_array($mes, $meses)) {
                return true;
            } else {
                return false;
            }
        }

        if ($frepag == 5) {
            if ($mes == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function check_cuota_socio($c_periodo, $c_sc)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".cuota WHERE c_periodo = '" . $c_periodo . "' AND c_sc = '" . $c_sc . "' AND c_anulada = 'NO'"));
        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_total_cuotas_generar($periodo)
    {
        include 'db.php';
        $condicion = get_frepag_periodo($periodo);
        $cant_sc = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio_categoria WHERE sc_estado = 'HABILITADO' AND sc_frepag IN " . $condicion));
        return $cant_sc[0];
    }

    function get_total_cuotas_generadas($periodo)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".cuota WHERE c_periodo = '" . $periodo . "' AND c_anulada = 'NO' AND c_futura = 'NO'"));
        return $count[0];
    }

    function get_ultimas_5_cuotas_socio($socio, $actividad)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.c_periodo, b.sc_nombre, c.c_nombre, d.forpag_nombre, e.frepag_nombre, f.b_nombre, g.c_nombre, a.c_monto, CASE WHEN a.c_comprobante = 0 THEN 'IMPAGA' ELSE 'PAGA' END FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".socio_categoria AS h ON a.c_sc = h.id INNER JOIN " . get_db() . ".subcategoria AS b ON a.c_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id INNER JOIN " . get_db() . ".forpag AS d ON a.c_forpag = d.id INNER JOIN " . get_db() . ".frepag AS e ON a.c_frepag = e.id INNER JOIN " . get_db() . ".beca AS f ON a.c_beca = f.id INNER JOIN " . get_db() . ".convenio AS g ON a.c_convenio = g.id WHERE a.c_socio = '" . $socio . "' AND a.c_sc = '" . $actividad . "' AND a.c_anulada = 'NO' ORDER BY a.c_periodo DESC LIMIT 0,5");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td mytitle='" . $f[0] . "'>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>" . $f[7] . "</td>";
            $tabla .= "<td>$ " . moneda($f[8]) . "</td>";
            $tabla .= "<td>" . $f[9] . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_info_cuota($id)
    {
        include 'db.php';

        $sql = "SELECT 
                    a.c_periodo, 
                    a.c_socio, 
                    b.s_apellido + ', ' + b.s_nombre, 
                    d.sc_nombre, 
                    e.c_nombre, 
                    f.forpag_nombre, 
                    g.frepag_nombre, 
                    h.b_nombre, 
                    i.c_nombre, 
                    a.c_monto, 
                    a.c_comprobante, 
                    a.c_alta, 
                    a.c_futura, 
                    a.c_anulada, 
                    d.id, 
                    a.c_frepag, 
                    a.c_beca, 
                    a.c_convenio,
                    a.c_sc
                FROM " . get_db() . ".cuota AS a 
                    INNER JOIN " . get_db() . ".socio AS b ON a.c_socio = b.id 
                    INNER JOIN " . get_db() . ".socio_categoria AS c ON a.c_sc = c.id 
                    INNER JOIN " . get_db() . ".subcategoria AS d ON a.c_subcategoria = d.id 
                    INNER JOIN " . get_db() . ".categoria AS e ON d.sc_categoria = e.id 
                    INNER JOIN " . get_db() . ".forpag AS f ON a.c_forpag = f.id 
                    INNER JOIN " . get_db() . ".frepag AS g ON a.c_frepag = g.id 
                    INNER JOIN " . get_db() . ".beca AS h ON a.c_beca = h.id 
                    INNER JOIN " . get_db() . ".convenio AS i ON a.c_convenio = i.id 
                WHERE a.id = '" . $id . "'";

        $cuota = mysqli_fetch_array(mysqli_query($conexion, $sql));


        if ($cuota[12] == 'NO') { //SI NO ES CUOTA FUTURA

            $valor_periodo = mysqli_fetch_array(mysqli_query($conexion, "SELECT CASE WHEN '" . $cuota[15] . "' = 1 THEN p_mensual WHEN '" . $cuota[15] . "' = 2 THEN p_bimestral WHEN '" . $cuota[15] . "' = 3 THEN p_trimestral WHEN '" . $cuota[15] . "' = 4 THEN p_semestral ELSE p_anual END FROM " . get_db() . ".periodo WHERE p_periodo = '" . $cuota[0] . "' AND p_subcategoria = '" . $cuota[14] . "'"));

            $porcentaje_beca = mysqli_fetch_array(mysqli_query($conexion, "SELECT b_porcentaje FROM " . get_db() . ".beca WHERE id = '" . $cuota[16] . "'"));
            $valor_beca = $valor_periodo[0] * $porcentaje_beca[0];

            $valor_convenio = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_monto FROM " . get_db() . ".convenio WHERE id = '" . $cuota[17] . "'"));

            array_push($cuota, $valor_periodo[0]); //18
            array_push($cuota, $valor_beca); //19
            array_push($cuota, $valor_convenio[0]); //20
        }

        if ($cuota[12] == 'SI') { //SI ES CUOTA FUTURA

            $valor_periodo = mysqli_fetch_array(mysqli_query($conexion, "SELECT CASE WHEN '" . $cuota[15] . "' = 1 THEN sc_mensual WHEN '" . $cuota[15] . "' = 2 THEN sc_bimestral WHEN '" . $cuota[15] . "' = 3 THEN sc_trimestral WHEN '" . $cuota[15] . "' = 4 THEN sc_semestral ELSE sc_anual END FROM " . get_db() . ".subcategoria WHERE id = '" . $cuota[14] . "'"));

            $porcentaje_beca = mysqli_fetch_array(mysqli_query($conexion, "SELECT b_porcentaje FROM " . get_db() . ".beca WHERE id = '" . $cuota[16] . "'"));
            $valor_beca = $valor_periodo[0] * $porcentaje_beca[0];

            $valor_convenio = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_monto FROM " . get_db() . ".convenio WHERE id = '" . $cuota[17] . "'"));

            array_push($cuota, $valor_periodo[0]); //18
            array_push($cuota, $valor_beca); //19
            array_push($cuota, $valor_convenio[0]); //20
        }

        return $cuota;
    }

    function anular_cuota($id)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".cuota SET c_anulada = 'SI' WHERE id = '" . $id . "'")) {
            auditoria('CUOTA', 'ANULACION DE CUOTA. ID: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function cobrar_cuota_individual($c_fecha, $c_cuota, $c_clase, $c_forpag, $c_caja, $c_monto)
    {
        include 'db.php';

        $c_monto = str_replace(",", ".", $c_monto);

        if (insert_comprobante($c_fecha, $c_cuota, $c_clase, $c_forpag, $c_caja, $c_monto)) {
            $c_usuario = get_id_usuario();

            $comprobante = get_nro_comprobante($c_fecha, $c_cuota, $c_clase, $c_usuario);



            if ($c_clase == "") {
                if (imputar_comprobante_cuota($c_cuota, $comprobante)) {

                    return true;
                } else {
                    insertar_error('No se pudo imputar el comprobante a la cuota');
                    return false;
                }
            } else {
                if (imputar_clase_paga($c_clase, $comprobante)) {
                    return true;
                } else {
                    insertar_error('No se pudo imputar como paga a la clase');
                    return false;
                }
            }
        } else {
            insertar_error('No se pudo insertar comprobante');
            return false;
        }
    }

    function get_ultimo_periodo_actividad($c_periodo, $c_sc)
    {
        include 'db.php';
        $fecha = date('Ymd', strtotime($c_periodo));
        $sql = "SELECT TOP 1 CAST(c_periodo AS varchar), c_frepag FROM " . get_db() . ".cuota WHERE c_sc = '" . $c_sc . "' AND c_anulada = 'NO' AND c_periodo < '" . $fecha . "' ORDER BY c_periodo DESC";
        $periodo = mysqli_fetch_array(mysqli_query($conexion, $sql));
        if (is_null($periodo)) {
            $periodo = array('1900-01-01', '1');
        }
        return $periodo;
    }

    function imputar_comprobante_cuota($c_cuota, $comprobante)
    {
        include 'db.php';
        if (comprobacion_cuota_grupofliar($c_cuota)) {
            $array_cuotas = get_id_cuotas_grupofliar($c_cuota);

            foreach ($array_cuotas as $id_cuota) {
                mysqli_query($conexion, "UPDATE " . get_db() . ".cuota SET c_comprobante = '" . $comprobante . "' WHERE id = '" . $id_cuota . "'");
                auditoria('CUOTA', 'CUOTA IMPUTADA. CUOTA: ' . $id_cuota . '. COMPROBANTE: ' . $comprobante);
            }
            return true;
        } else {
            if (mysqli_query($conexion, "UPDATE " . get_db() . ".cuota SET c_comprobante = '" . $comprobante . "' WHERE id = '" . $c_cuota . "'")) {
                auditoria('CUOTA', 'CUOTA IMPUTADA. CUOTA: ' . $c_cuota . '. COMPROBANTE: ' . $comprobante);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function get_deuda_acumulada_socio($id)
    {
        include 'db.php';
        $monto = 0;
        $result = mysqli_query($conexion, "SELECT id FROM " . get_db() . ".socio_categoria WHERE sc_socio = '" . $id . "' AND sc_estado = 'HABILITADO'");
        while ($fila = mysqli_fetch_array($result)) {
            $aux_monto = mysqli_fetch_array(mysqli_query($conexion, "SELECT SUM(c_monto) FROM " . get_db() . ".cuota WHERE c_sc = '" . $fila[0] . "' AND c_comprobante = 0 AND c_anulada = 'NO'"));
            $monto = $monto + $aux_monto[0];
        }

        $actividades = mysqli_fetch_array(mysqli_query($conexion, "SELECT SUM(a.sc_monto) FROM " . get_db() . ".socio_clase AS a WHERE a.sc_socio = '" . $id . "' AND a.sc_estado = 'IMPAGA'"));
        $monto = $monto + $actividades[0];

        return '$ ' . moneda($monto);
    }

    function desrendir_cuota($id)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".cuota SET c_comprobante = 0 WHERE id = '" . $id . "'")) {
            auditoria('CUOTA', 'CUOTA DESRENDIDA. CUOTA: ' . $id);
            return true;
        } else {
            return false;
        }
    }

    function get_listado_cuotas_anuladas($actividad)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.c_periodo, d.forpag_nombre, e.frepag_nombre, f.b_nombre, g.c_nombre, a.c_monto, a.c_alta FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".socio_categoria AS h ON a.c_sc = h.id INNER JOIN " . get_db() . ".subcategoria AS b ON h.sc_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id INNER JOIN " . get_db() . ".forpag AS d ON a.c_forpag = d.id INNER JOIN " . get_db() . ".frepag AS e ON a.c_frepag = e.id INNER JOIN " . get_db() . ".beca AS f ON a.c_beca = f.id INNER JOIN " . get_db() . ".convenio AS g ON a.c_convenio = g.id WHERE a.c_sc = '" . $actividad . "' AND a.c_anulada = 'SI' ORDER BY a.c_periodo DESC");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[1]->format('m/Y') . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>$ " . moneda($f[6]) . "</td>";
            $tabla .= "<td>" . $f[7]->format('d/m/Y H:i:s') . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function comprobacion_cuota_grupofliar($c_cuota)
    {
        include 'db.php';
        $grupo = mysqli_fetch_array(mysqli_query($conexion, "SELECT b.sc_grupofliar FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.c_subcategoria = b.id WHERE a.id = " . $c_cuota));
        if ($grupo[0] == 'SI') {
            return true;
        } else {
            return false;
        }
    }

    function get_id_cuotas_grupofliar($c_cuota)
    {
        include 'db.php';
        $cuotas = array();

        $info_cuota = get_info_cuota($c_cuota);

        $gf_cabecera = $info_cuota[18];
        $c_periodo = $info_cuota[0];

        $sql = "SELECT a.id FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".grupo_fliar AS b ON a.c_sc = b.gf_integrante WHERE b.gf_cabecera = '" . $gf_cabecera . "' AND a.c_periodo = '" . $c_periodo . "'";
        $result = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($result)) {
            array_push($cuotas, $fila[0]);
        }
        //print_r($cuotas);
        return $cuotas;
    }
}

/* ACTIVIDADES */ {

    function get_info_actividad($id)
    {
        include 'db.php';
        $actividad = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio_categoria WHERE id = '" . $id . "'"));
        return $actividad;
    }

    function get_info_actividad_editar($id)
    {
        include 'db.php';
        $actividad = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, c.id, a.sc_subcategoria, a.sc_forpag, a.sc_frepag, a.sc_beca, a.sc_convenio, a.sc_debito_tarjeta, a.sc_debito_vencimiento, a.sc_tarjeta, a.sc_debito_cbu, a.sc_debito_titular, a.sc_debito_entidad, a.sc_socio FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.sc_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id WHERE a.id = '" . $id . "'"));
        return $actividad;
    }

    function editar_socio_categoria($id, $sc_subcategoria, $sc_forpag, $sc_frepag, $sc_beca, $sc_convenio, $sc_debito_tarjeta, $sc_debito_vencimiento, $sc_tarjeta, $sc_debito_cbu, $sc_debito_titular, $sc_debito_entidad)
    {
        include 'db.php';
        if (mysqli_query($conexion, "UPDATE " . get_db() . ".socio_categoria SET sc_subcategoria = '" . $sc_subcategoria . "', sc_forpag = '" . $sc_forpag . "', sc_frepag = '" . $sc_frepag . "', sc_beca = '" . $sc_beca . "', sc_convenio = '" . $sc_convenio . "', sc_debito_tarjeta = '" . $sc_debito_tarjeta . "', sc_debito_vencimiento = '" . $sc_debito_vencimiento . "', sc_tarjeta = '" . $sc_tarjeta . "', sc_debito_cbu = '" . $sc_debito_cbu . "', sc_debito_titular = '" . $sc_debito_titular . "', sc_debito_entidad = '" . $sc_debito_entidad . "' WHERE id = '" . $id . "'")) {
            auditoria('ACTIVIDAD', 'UPDATE ACTIVIDAD. SUBCATEGORIA: ' . $sc_subcategoria . '. FORPAG: ' . $sc_forpag . '. FREPAG: ' . $sc_frepag . '. BECA: ' . $sc_beca . '. CONVENIO: ' . $sc_convenio . '. NRO TARJETA: ' . $sc_debito_tarjeta . '. VENC TARJETA: ' . $sc_debito_vencimiento . '. TARJETA: ' . $sc_tarjeta . '. NRO CBU: ' . $sc_debito_cbu . '. TITULAR CBU: ' . $sc_debito_titual . '. ENTIDAD: ' . $sc_debito_entidad . '. ID: ' . $id);

            return true;
        } else {
            return false;
        }
    }

    function get_info_detallada_actividad($id)
    {
        include 'db.php';
        $datos = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, a.sc_socio, b.s_apellido + ', ' + b.s_nombre, c.sc_nombre, d.c_nombre, e.forpag_nombre, f.frepag_nombre, g.b_nombre, h.c_nombre, i.t_nombre, c.sc_grupofliar FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".socio AS b ON a.sc_socio = b.id INNER JOIN " . get_db() . ".subcategoria AS c ON a.sc_subcategoria = c.id INNER JOIN " . get_db() . ".categoria AS d ON c.sc_categoria = d.id INNER JOIN " . get_db() . ".forpag AS e ON a.sc_forpag = e.id INNER JOIN " . get_db() . ".frepag AS f ON a.sc_frepag = f.id INNER JOIN " . get_db() . ".beca AS g ON a.sc_beca = g.id INNER JOIN " . get_db() . ".convenio AS h ON a.sc_convenio = h.id INNER JOIN " . get_db() . ".tarjeta AS i ON a.sc_tarjeta = i.id WHERE a.id = '" . $id . "'"));
        return $datos;
    }

    function condiciones_alta_categoria_socio($sc_socio, $sc_subcategoria)
    {
        include 'db.php';
        $subcategoria = mysqli_fetch_array(mysqli_query($conexion, "SELECT sc_edadini, sc_edadfin FROM " . get_db() . ".subcategoria WHERE id = '" . $sc_subcategoria . "'"));

        $edad = get_edad_socio($sc_socio);

        if ($edad >= $subcategoria['sc_edadini'] && $edad <= $subcategoria['sc_edadfin']) {
            return true;
        } else {
            return false;
        }
    }

    function alta_socio_categoria($sc_socio, $sc_subcategoria, $sc_forpag, $sc_frepag, $sc_beca, $sc_convenio, $sc_debito_tarjeta, $sc_vencimiento, $sc_tarjeta, $sc_debito_cbu, $sc_titular, $sc_entidad)
    {
        include 'db.php';
        if (check_actividad_socio($sc_socio, $sc_subcategoria)) {
            if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".socio_categoria (sc_socio, sc_subcategoria, sc_forpag, sc_frepag, sc_beca, sc_convenio, sc_debito_tarjeta, sc_debito_vencimiento, sc_tarjeta, sc_debito_cbu, sc_debito_titular, sc_debito_entidad) VALUES ('" . $sc_socio . "', '" . $sc_subcategoria . "', '" . $sc_forpag . "', '" . $sc_frepag . "', '" . $sc_beca . "', '" . $sc_convenio . "', '" . $sc_debito_tarjeta . "', '" . $sc_vencimiento . "', '" . $sc_tarjeta . "', '" . $sc_debito_cbu . "', '" . $sc_titular . "', '" . $sc_entidad . "')")) {
                auditoria('ACTIVIDAD', 'NUEVA ACTIVIDAD. SOCIO: ' . $sc_socio . ' SUBCATEGORIA: ' . $sc_subcategoria . '. FORPAG: ' . $sc_forpag . '. FREPAG: ' . $sc_frepag . '. BECA: ' . $sc_beca . '. CONVENIO: ' . $sc_convenio . '. NRO TARJETA: ' . $sc_debito_tarjeta . '. VENC TARJETA: ' . $sc_debito_vencimiento . '. TARJETA: ' . $sc_tarjeta . '. NRO CBU: ' . $sc_debito_cbu . '. TITULAR CBU: ' . $sc_debito_titual . '. ENTIDAD: ' . $sc_debito_entidad);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function check_actividad_socio($sc_socio, $sc_subcategoria)
    {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio_categoria WHERE sc_socio = '" . $sc_socio . "' AND sc_subcategoria = '" . $sc_subcategoria . "'"));
        if ($count[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_listado_actividades_socio($id)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.c_nombre, b.sc_nombre, d.forpag_nombre, e.frepag_nombre, f.b_nombre, g.c_nombre, a.sc_estado FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.sc_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id INNER JOIN " . get_db() . ".forpag AS d ON a.sc_forpag = d.id INNER JOIN " . get_db() . ".frepag AS e ON a.sc_frepag = e.id INNER JOIN " . get_db() . ".beca AS f ON a.sc_beca = f.id INNER JOIN " . get_db() . ".convenio AS g ON a.sc_convenio = g.id WHERE a.sc_socio = '" . $id . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>" . $f[7] . "</td>";
            $tabla .= "<td><a class='mr-2' href='actividades_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a><a href='actividades_editar.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-edit'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_ad_actividades_socio($id)
    {
        include 'db.php';
        $opciones = "";
        $result = mysqli_query($conexion, "SELECT a.id, b.sc_nombre, c.c_nombre FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.sc_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id WHERE a.sc_socio = '" . $id . "'");
        while ($fila = mysqli_fetch_array($result)) {
            $opciones .= '<a class="dropdown-item" role="presentation" href="actividades_info.php?id=' . $fila[0] . '">' . $fila[2] . ' - ' . $fila[1] . '</a>';
        }
        return $opciones;
    }
}

/* GRUPO FAMILIARES */ {

    function get_listado_grupofliar($cabecera)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.gf_integrante, c.sc_nombre, d.c_nombre, e.s_apellido + ', ' + e.s_nombre, e.s_documento FROM " . get_db() . ".grupo_fliar AS a INNER JOIN " . get_db() . ".socio_categoria AS b ON a.gf_integrante = b.id INNER JOIN " . get_db() . ".subcategoria AS c ON b.sc_subcategoria = c.id INNER JOIN " . get_db() . ".categoria AS d ON c.sc_categoria = d.id INNER JOIN " . get_db() . ".socio AS e ON b.sc_socio = e.id WHERE a.gf_cabecera = '" . $cabecera . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td><a class='mr-2' href='actividades_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a><a href='actividades_editar.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-edit'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_cabecera_grupofliar($integrante)
    {
        include 'db.php';
        $nro = mysqli_fetch_array(mysqli_query($conexion, "SELECT gf_cabecera FROM " . get_db() . ".grupo_fliar WHERE gf_integrante = '" . $integrante . "'"));
        if ($nro[0] == null) {
            $cabecera = 0;
        } else {
            $cabecera = $nro[0];
        }
        return $cabecera;
    }

    function get_integrante_grupofliar($cabecera)
    {
        include 'db.php';
        $integrante = mysqli_fetch_array(mysqli_query($conexion, "SELECT gf_integrante FROM " . get_db() . ".grupo_fliar WHERE gf_cabecera = '" . $cabecera . "'"));
        return $integrante[0];
    }

    function get_cantidad_grupofliar($cabecera)
    {
        include 'db.php';
        $integrante = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(gf_integrante) FROM " . get_db() . ".grupo_fliar WHERE gf_cabecera = '" . $cabecera . "'"));
        return $integrante[0];
    }

    function agregar_integrante_grupofliar($gf_cabecera, $gf_integrante)
    {
        include 'db.php';
        if (check_integrante_grupofliar($gf_cabecera, $gf_integrante)) {
            if (mysqli_query($conexion, "INSERT INTO " . get_db() . ".grupo_fliar (gf_cabecera, gf_integrante) VALUES ('" . $gf_cabecera . "', '" . $gf_integrante . "')")) {
                auditoria('GRUPO FAMILIAR', 'NUEVO INTEGRANTE A GRUPO FLIAR. CABECERA: ' . $gf_cabecera . '. INTEGRANTE: ' . $gf_integrante . '. USUARIO: ' . get_id_usuario());
                return true;
            } else {
                return false;
            }
        }
    }

    function check_integrante_grupofliar($gf_cabecera, $gf_integrante)
    {
        include 'db.php';
        $cantidad = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".grupo_fliar WHERE gf_cabecera = '" . $gf_cabecera . "' AND gf_integrante = '" . $gf_integrante . "'"));
        if ($cantidad[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_select_socios_grupofliares()
    {
        include 'db.php';
        $options = "<option value=''>Seleccione una opción</option>";
        $r = mysqli_query($conexion, "SELECT a.id, b.s_apellido + ', ' + b.s_nombre, b.s_documento FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".socio AS b ON a.sc_socio = b.id INNER JOIN " . get_db() . ".subcategoria AS c ON a.sc_subcategoria = c.id WHERE c.sc_grupofliar = 'SI' AND b.s_estado = '1' ORDER BY b.s_apellido ASC");
        while ($f = mysqli_fetch_array($r)) {
            $options .= "<option value='" . $f[0] . "'>" . $f[1] . " - " . $f[2] . "</option>";
        }
        return $options;
    }
}

/* CAJAS */ {

    function get_select_cajas($caja)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, c_nombre FROM " . get_db() . ".caja ORDER BY id ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($caja != 0) {
                if ($caja == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }
}

/* COMPROBANTES */ {

    function insert_comprobante($c_fecha, $c_cuota, $c_clase, $c_forpag, $c_caja, $c_monto)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".comprobante (c_fecha, c_cuota, c_clase, c_forpag, c_caja, c_monto, c_usuario) VALUES ('" . $c_fecha . "', '" . $c_cuota . "', '" . $c_clase . "', '" . $c_forpag . "', '" . $c_caja . "', '" . $c_monto . "', '" . get_id_usuario() . "')";
        if (mysqli_query($conexion, $sql)) {
            auditoria('COMPROBANTE', 'NUEVO COMPROBANTE. FECHA: ' . $c_fecha . '. CUOTA: ' . $c_cuota . '. CLASE: ' . $c_clase . '. FORPAG: ' . $c_forpag . '. CAJA: ' . $c_caja . '. MONTO: ' . $c_monto);
            return true;
        } else {
            insertar_error('No se pudo insertar el comprobante. SQL: ' . seguridad($sql));
            return false;
        }
    }

    function get_nro_comprobante($c_fecha, $c_cuota, $c_clase, $c_usuario)
    {
        include 'db.php';
        $id = mysqli_fetch_array(mysqli_query($conexion, "SELECT id FROM " . get_db() . ".comprobante WHERE c_fecha = '" . $c_fecha . "' AND c_cuota = '" . $c_cuota . "' AND c_clase = '" . $c_clase . "' AND c_usuario = '" . $c_usuario . "' ORDER BY id DESC LIMIT 0,1"));
        return $id[0];
    }

    function get_info_comprobante($id)
    {
        include 'db.php';
        $comprobante = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".comprobante WHERE id = '" . $id . "'"));
        return $comprobante;
    }
}

/* INGRESOS */ {

    function get_ingresos_mensuales()
    {
        include 'db.php';
        $ingresos = mysqli_fetch_array(mysqli_query($conexion, "SELECT SUM(c_monto) FROM " . get_db() . ".comprobante WHERE YEAR(c_fecha) = '" . date('Y') . "' AND MONTH(c_fecha) = '" . date('m') . "'"));
        return '$ ' . moneda($ingresos[0]);
    }
}

/* MOROSOS */ {

    function reporte_morosos($fecini, $fecfin, $categoria, $subcategoria)
    {
        include 'db.php';
        $inicio = date('Ym01', strtotime($fecini));
        $fin = date('Ym01', strtotime($fecfin));

        $query_categoria = "";

        if ($categoria == 'TODAS') {
            $query_categoria .= '';
        } else {
            $query_categoria .= ' AND d.id = ' . $categoria;
            if ($subcategoria == 'TODAS') {
                $query_categoria .= '';
            } else {
                $query_categoria .= ' AND c.id = ' . $subcategoria;
            }
        }

        $tabla = "";

        $sql = "SELECT a.c_socio, CONCAT(b.s_apellido, ', ', b.s_nombre), b.s_documento, d.c_nombre, c.sc_nombre, (SELECT SUM(e.c_monto) FROM " . get_db() . ".cuota AS e WHERE e.c_sc = a.c_sc AND e.c_comprobante = 0 AND e.c_anulada = 'NO') FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".socio AS b ON a.c_socio = b.id INNER JOIN " . get_db() . ".subcategoria AS c ON a.c_subcategoria = c.id INNER JOIN " . get_db() . ".categoria AS d ON c.sc_categoria = d.id WHERE a.c_periodo BETWEEN '" . $inicio . "' AND '" . $fin . "' AND a.c_comprobante = 0 AND a.c_anulada = 'NO'" . $query_categoria . ' GROUP BY a.c_socio, b.s_apellido, b.s_nombre, b.s_documento, d.c_nombre, c.sc_nombre, a.c_sc';

        //consola($sql);

        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>$ " . moneda($f[5]) . "</td>";
            $tabla .= "<td><a href='socio_info.php?id=" . $f[0] . "'><i class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }
}

/* LOTES */ {

    function cambiar_estado_lote($id_lote, $nombre_archivo, $estado) {
        include 'db.php';
        $base = get_db();
        $sql = "UPDATE {$base}.lote SET l_devolucion='{$nombre_archivo}', l_estado='FINALIZADO' WHERE id = {$id_lote}";
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception("Falló la actualización del lote {$id_lote}");
        }
    }

    function get_nombre_forpag($forpag) {
        include 'db.php';
        $base = get_db();
        $sql = "SELECT fp.forpag_nombre FROM {$base}.forpag AS fp WHERE fp.id = {$forpag}";
        $result = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $result[0];
    }

    function get_datos_tarjeta($tarjeta) {
        include 'db.php';
        $base = get_db();
        $sql = "SELECT t.id, t.t_nombre, t.t_establecimiento, t.t_forpag, t.t_DoC, t.t_empresa_debito, t.t_nombre_clase FROM {$base}.tarjeta AS t WHERE t.id = {$tarjeta}";
        return mysqli_fetch_array(mysqli_query($conexion, $sql));
    }

    function get_datos_lote($id_lote) {
        include 'db.php';
        $base = get_db();
        $sql = "SELECT l.id, l.l_tarjeta FROM {$base}.lote AS l WHERE l.id = {$id_lote}";
        return mysqli_fetch_array(mysqli_query($conexion, $sql));
    }

    function get_lista_cuotas_a_debitar($forpag, $tarjeta) {
        include 'db.php';
        $base = get_db();
        $sql = "SELECT cuota.id, DATE_FORMAT(cuota.c_periodo, '%m/%y') as c_periodo, cuota.c_socio, SUM(cuota.c_monto) as c_monto, DATE_FORMAT(cuota.c_alta, '%Y%m%d') as c_alta,
                       socio.id as s_id, socio.s_documento,
                       forpag.forpag_nombre,
                       soccat.sc_debito_tarjeta, soccat.sc_debito_vencimiento,
                       tarje.t_nombre, tarje.t_establecimiento, tarje.t_DoC,
                       categ.c_nombre,
                       subcat.sc_nombre,
                       CASE WHEN EXISTS(SELECT * FROM {$base}.primer_debito AS p WHERE p.NroTarjeta = soccat.sc_debito_tarjeta) THEN FALSE ELSE TRUE END as primer_debito
                FROM  {$base}.cuota AS cuota 
                INNER JOIN {$base}.socio AS socio ON socio.id = cuota.c_socio AND cuota.c_monto > 0 AND cuota.c_anulada = 'NO'
                                                     AND YEAR(cuota.c_periodo) = YEAR(CURDATE()) AND MONTH(cuota.c_periodo) = MONTH(CURDATE())
                INNER JOIN {$base}.forpag AS forpag ON cuota.c_forpag = forpag.id AND forpag.id = {$forpag} AND forpag.forpag_debito = 'S'
                INNER JOIN {$base}.socio_categoria AS soccat ON cuota.c_sc = soccat.id AND soccat.sc_estado = 'HABILITADO'
                INNER JOIN {$base}.tarjeta AS tarje ON tarje.id = soccat.sc_tarjeta AND tarje.id = {$tarjeta} AND tarje.t_estado = 'HABILITADO'
                INNER JOIN {$base}.subcategoria AS subcat ON soccat.sc_subcategoria = subcat.id AND subcat.sc_estado = 'HABILITADO'
                INNER JOIN {$base}.categoria AS categ ON categ.id = subcat.sc_categoria
                GROUP BY soccat.sc_debito_tarjeta";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }

    function generar_lote($forma_pago, $tarjeta = null) {
        include 'db.php';
        $base = get_db();

        $lista_debitos = get_lista_cuotas_a_debitar($forma_pago, $tarjeta);

        if (!mysqli_num_rows($lista_debitos)) {
            return false;
        }

        $nombre_forma_pago = get_nombre_forpag($forma_pago);
        $datos_tarjeta = get_datos_tarjeta($tarjeta); // id, t_nombre, t_establecimiento, t_DoC, t_empresa_debito
        $id_tarjeta = $datos_tarjeta["id"];
        $nombre_clase = "orden_debito_{$datos_tarjeta["t_nombre_clase"]}";

        require_once "{$nombre_clase}.php";
       
        $archivo = new $nombre_clase($lista_debitos, $nombre_forma_pago, $datos_tarjeta);
        $archivo->convertir();
        return $archivo->guardar_archivo($base) && 
               agregar_lote($id_tarjeta, get_id_usuario(), $archivo->get_nombre_archivo(), $archivo->get_cant_registros(), $archivo->get_suma_importes());
    }

    function agregar_lote($id_tarjeta, $id_usuario, $nombre_archivo, $cant_registros, $suma_importes) {
        include 'db.php';
        $base = get_db();
        $date = new DateTime();
        $time = $date->format('Y-m-d H:i:s');
        $sql = "INSERT INTO {$base}.lote (l_tarjeta, l_usuario, l_archivo, l_cant_registros, l_suma_importes) 
                VALUES ({$id_tarjeta}, {$id_usuario}, '{$nombre_archivo}', {$cant_registros}, {$suma_importes})";
        if (mysqli_query($conexion, $sql)) {
            auditoria('LOTE', "NUEVO LOTE. ID TARJETA: {$id_tarjeta}. ARCHIVO: {$nombre_archivo}. TIME: {$time}. USUARIO: {$id_usuario}");
            return true;
        }
        else {
            return false;
        }
    }

    function obtener_cuota_debito($tarjeta, $socio, $ano_debito, $mes_debito, $monto) {
        // Devuelve el id de la cuota que cumple la condición o FALSE
        include 'db.php';
        $base = get_db();
        $sql = "SELECT cuota.id
                FROM {$base}.cuota AS cuota 
                INNER JOIN {$base}.socio_categoria AS soccat ON cuota.c_sc = soccat.id
                AND soccat.sc_debito_tarjeta = '{$tarjeta}'
                AND cuota.c_socio = {$socio}
                AND DATE_FORMAT(cuota.c_periodo, '%Y') = {$ano_debito}
                AND DATE_FORMAT(cuota.c_periodo, '%m') = {$mes_debito}
                AND cuota.c_anulada = 'NO'
                AND cuota.c_monto = {$monto}";
        $result = mysqli_query($conexion, $sql);
        if ($result && (mysqli_num_rows($result) == 1)) {
            return mysqli_fetch_array($result)[0];
        }
        else {
            throw new Exception("No existe en la base de datos la cuota informada.");
        }
    }

    function obtener_cuotas_debito($tarjeta, $socio, $ano_debito, $mes_debito, $monto) {
        // Devuelve los id de las cuotas que cumplen la condición
        include 'db.php';
        $base = get_db();
        $sql = "SELECT cuota.id
                FROM {$base}.cuota AS cuota 
                INNER JOIN {$base}.socio AS socio ON socio.id = {$socio} AND socio.id = cuota.c_socio AND cuota.c_monto > 0 AND cuota.c_anulada = 'NO' AND
                                                     DATE_FORMAT(cuota.c_periodo, '%Y') = '{$ano_debito}' AND DATE_FORMAT(cuota.c_periodo, '%m') = '{$mes_debito}'
                INNER JOIN {$base}.socio_categoria AS soccat ON cuota.c_sc = soccat.id AND soccat.sc_debito_tarjeta = '{$tarjeta}' AND soccat.sc_estado = 'HABILITADO'
                INNER JOIN {$base}.tarjeta AS tarje ON tarje.id = soccat.sc_tarjeta AND tarje.t_estado = 'HABILITADO'
                INNER JOIN {$base}.subcategoria AS subcat ON soccat.sc_subcategoria = subcat.id AND subcat.sc_estado = 'HABILITADO'
                INNER JOIN {$base}.categoria AS categ ON categ.id = subcat.sc_categoria";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }

    function agregar_comprobante($id_cuota, $identificador) {
        include 'db.php';
        $base = get_db();
        $date = date("Ymd");
        $sql = "UPDATE {$base}.cuota
                SET c_comprobante = '{$identificador}{$date}'
                WHERE id = {$id_cuota}";
        return mysqli_query($conexion, $sql);
    }

    function insertar_rechazo($id_lote, $socio, $tarjeta, $fecha_origen, $monto, $identificador, $cod_rechazo, $descripcion_rechazo) {
        include 'db.php';
        $base = get_db();
        $sql = "INSERT INTO {$base}.rechazo (r_lote, r_socio, tarjeta, fecha_origen, importe, identificador, cod_rechazo, descripcion_rechazo)
                VALUES ({$id_lote}, {$socio}, '{$tarjeta}', '{$fecha_origen}', {$monto}, '{$identificador}', '{$cod_rechazo}', '{$descripcion_rechazo}')";
        return mysqli_query($conexion, $sql);
    }

    function socio_id_exists($id) {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM " . get_db() . ".socio WHERE id = {$id}"));
        if ($count[0] == 0) {
            throw new Exception("No existe en la base de datos el socio {$id}.");
        }
        return TRUE;
    }

    function tarjeta_exists($tarjeta) {
        include 'db.php';
        $count = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(*) FROM " . get_db() . ".socio_categoria WHERE sc_debito_tarjeta = '{$tarjeta}'"));
        if ($count[0] == 0) {
            throw new Exception("No existe en la base de datos la tarjeta {$tarjeta}.");
        }
        return TRUE;
    }

    function actualizar_cuota($id_lote, $devolucion) {
        /* DEVOLUCION FISERV
            AC243383300018163350000000000000001429000000020000000123110009/21090821                                        230821                                           
            ["TipoRegistro"]=> string(1) "2" 
            ["NroTarjeta"]=> string(16) "4338330001816335" 
            ["NroReferencia"]=> string(12) "000000001429" 
            ["Importe"]=> string(11) "00000200000" 
            ["CantCuotas"]=> string(3) "001" 
            ["Vencimiento"]=> string(4) "2311" 
            ["CodRechazo"]=> string(2) "00" 
            ["DescripcionRechazo"]=> string(68) "Indicación de transacción aceptada o tarjeta con cambio de número" 
            ["Periodo"]=> string(5) "09/21" 
            ["FechaPresentacion"]=> string(6) "090821"  */

        /*  TABLA RECHAZOS
            r_lote       	        int(11)
            r_socio 	            int(11)
            tarjeta 	            varchar(100)
            fecha_origen 	        datetime
            importe 	            decimal(18,2)
            identificador 	        varchar(15)
            cod_rechazo 	        varchar(255)
            descripcion_rechazo     varchar(255)    */
        $socio = $devolucion["Socio"];
        $nro_tarjeta = $devolucion["NroTarjeta"];
        $ano_debito = $devolucion["PeriodoAno"];
        $mes_debito = $devolucion["PeriodoMes"];
        $fecha_origen = $devolucion["FechaOrigen"];
        $monto = $devolucion["Monto"] / 100;
        $identificador = $devolucion["Identificador"];
        $cod_rechazo = $devolucion["CodRechazo"];
        $descripcion_rechazo = $devolucion["DescripcionRechazo"];

        try {
            socio_id_exists($socio);
            tarjeta_exists($nro_tarjeta);
            $cuotas = obtener_cuotas_debito($nro_tarjeta, $socio, $ano_debito, $mes_debito, $monto);

            if ($cod_rechazo == 0) {   // se debitó
                while ($cuota = mysqli_fetch_array($cuotas)) {
                    $c = $cuota['id'];
                    if (!agregar_comprobante($c, $identificador, $socio)) {
                        throw new Exception("Falló la actualización de la cuota {$c}");
                    }
                }
            }
            else {  // se rechazó
                if (!insertar_rechazo($id_lote, $socio, $nro_tarjeta, $fecha_origen, $monto, $identificador, $cod_rechazo, $descripcion_rechazo)) {
                    throw new Exception("Falló el registro del rechazo: tarjeta {$tarjeta}, socio {$socio}");
                }
            }
        }
        catch (Exception $e) {
            if (!insertar_rechazo($id_lote, $socio, $nro_tarjeta, $fecha_origen, $monto, $identificador, "999", $e->getMessage())) {
                throw new Exception("Falló el registro del rechazo: tarjeta {$nro_tarjeta}, socio {$socio}. {$e->getMessage()}");
            }
        }
    }

    /*  $cambiar_tarjeta = function ($tarjeta_vieja, $tarjeta_nueva) {
            include 'db.php';
            $base = get_db();
            $sql = "UPDATE {$base}.socio_categoria
                    SET sc_debito_tarjeta = '{$tarjeta_nueva}'
                    WHERE sc_debito_tarjeta = '{$tarjeta_vieja}'";
            return mysqli_query($conexion, $sql);
        };
    */

    function agregar_devolucion($id_lote, $nombre_archivo) {
        include 'db.php';
        $base = get_db();
        $time = (new DateTime())->format('Y-m-d H:i:s');
        $id_usuario = get_id_usuario();

        $datos_lote = get_datos_lote($id_lote);  
        $id_tarjeta = $datos_lote["l_tarjeta"];

        $datos_tarjeta = get_datos_tarjeta($id_tarjeta); // id, t_nombre, t_establecimiento, t_forpag, t_DoC, t_empresa_debito
        // $nombre_forma_pago = get_nombre_forpag($datos_tarjeta["t_forpag"]);

        $nombre_clase = "devolucion_debito_{$datos_tarjeta["t_nombre_clase"]}";

        require_once "{$nombre_clase}.php";

        // actualizar lote y cuotas
        $archivo = new $nombre_clase($nombre_archivo, $base, $datos_tarjeta /*, $cambiar_tarjeta*/);
        $devoluciones = $archivo->get_lista_devoluciones();

        mysqli_begin_transaction($conexion, MYSQLI_TRANS_START_READ_WRITE);
        try {
            foreach ($devoluciones as $devolucion) {
                actualizar_cuota($id_lote, $devolucion);
            }
            cambiar_estado_lote($id_lote, $nombre_archivo, 'FINALIZADO');
            
            mysqli_commit($conexion);
            auditoria('LOTE', "NUEVA DEVOLUCION ID LOTE: {$id_lote}. ARCHIVO: {$nombre_archivo}. TIME: {$time}. USUARIO: {$id_usuario}");
        }
        catch (Exception $e) {
            mysqli_rollback($conexion);
            throw $e;
        }
        return TRUE;
    }

    function get_lista_lotes()
    {
        include 'db.php';
        $data = array();
        $base = get_db();
        $sql = "SELECT L.id, '{$base}' as base, T.t_empresa_debito, T.t_nombre, U.u_usuario, L.l_archivo, L.l_devolucion, L.l_cant_registros, L.l_suma_importes, L.l_alta
                FROM {$base}.lote L
                INNER JOIN {$base}.tarjeta T ON L.l_tarjeta = T.id
                INNER JOIN {$sportapp_db}.tb_usuario U ON L.l_usuario = U.id";
        $r = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($r)) {
            array_push($data, $fila);
        }
        return $data;
    }

    function get_lista_rechazos($lote) {
        include 'db.php';
        $data = array();
        $base = get_db();
        $sql = "SELECT R.id, R.r_socio, R.tarjeta, R.fecha_origen, R.importe, R.identificador, R.cod_rechazo, R.descripcion_rechazo
                FROM {$base}.rechazo R
                WHERE R.r_lote = {$lote}";
        $r = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($r)) {
            array_push($data, $fila);
        }
        return $data;
    }

    function get_listado_lotes() { // es de Juani; no la uso
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>$ " . moneda($f[5]) . "</td>";
            $tabla .= "<td><a href='socio_info.php?id=" . $f[0] . "'><i class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }
}

/* PROFESORES */ {

    function get_listado_profesores()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT * FROM " . get_db() . ".profesor");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>" . ($f[7] * 100) . "%</td>";
            $tabla .= "<td>$ " . moneda($f[8]) . "</td>";
            $tabla .= "<td><a class='mr-2' href='profesores_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_select_profesor($profesor)
    {
        include 'db.php';
        $options = "";
        $r = mysqli_query($conexion, "SELECT id, p_nombre FROM " . get_db() . ".profesor ORDER BY p_nombre ASC");
        while ($f = mysqli_fetch_array($r)) {
            if ($profesor != 0) {
                if ($profesor == $f[0]) {
                    $options .= "<option class='" . $f[0] . "' selected value='" . $f[0] . "'>" . $f[1] . "</option>";
                } else {
                    $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
                }
            } else {
                $options .= "<option class='" . $f[0] . "' value='" . $f[0] . "'>" . $f[1] . "</option>";
            }
        }
        return $options;
    }

    function get_info_profesor($id)
    {
        include 'db.php';
        $profesor = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".profesor WHERE id = '" . $id . "'"));
        return $profesor;
    }

    function insert_profesor($p_nombre, $p_cuit, $p_documento, $p_telefono, $p_celular, $p_email, $p_comision, $p_sueldo)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".profesor (p_nombre, p_cuit, p_documento, p_telefono, p_celular, p_email, p_comision, p_sueldo) VALUES ('" . strtoupper($p_nombre) . "', '" . $p_cuit . "', '" . $p_documento . "', '" . $p_telefono . "', '" . $p_celular . "', '" . $p_email . "', " . ($p_comision / 100) . ", " . $p_sueldo . ")";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function update_profesor($id, $p_nombre, $p_cuit, $p_documento, $p_telefono, $p_celular, $p_email, $p_comision, $p_sueldo)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".profesor SET p_nombre = '" . strtoupper($p_nombre) . "', p_cuit = '" . $p_cuit . "', p_documento = '" . $p_documento . "', p_telefono = '" . $p_telefono . "', p_celular = '" . $p_celular . "', p_email = '" . $p_email . "', p_comision = " . ($p_comision / 100) . ", p_sueldo = " . $p_sueldo . " WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function get_listado_actividades_profesor($id)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.a_nombre FROM " . get_db() . ".actividad AS a WHERE a.a_profesor = '" . $id . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td><a class='mr-2' href='disciplina_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_suma_pagos_profesor($profesor, $fecini, $fecfin)
    {
        include 'db.php';
        $sql = "SELECT COUNT(a.id) AS 'Cantidad', SUM(a.sc_monto) AS 'Monto' FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id INNER JOIN " . get_db() . ".comprobante AS d ON a.sc_comprobante = d.id WHERE a.sc_estado = 'PAGA' AND d.c_fecha BETWEEN '" . $fecini . "' AND '" . $fecfin . "' AND c.a_profesor = " . $profesor;
        consola($sql);
        $datos = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $datos;
    }
}

/* DISCIPLINAS */ {

    function insert_disciplina($a_nombre, $a_descripcion, $a_profesor, $a_fecini, $a_fecfin, $a_monto_mensual, $a_monto_clase, $a_cupo, $a_limite_cancelacion)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".actividad (a_nombre, a_descripcion, a_profesor, a_fecini, a_fecfin, a_monto_mensual, a_monto_clase, a_cupo, a_limite_cancelacion) VALUES ('" . strtoupper($a_nombre) . "', '" . $a_descripcion . "', '" . $a_profesor . "', '" . $a_fecini . "', '" . $a_fecfin . "', '" . $a_monto_mensual . "', '" . $a_monto_clase . "', '" . $a_cupo . "', '" . $a_limite_cancelacion . "')";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function get_info_disciplina($id)
    {
        include 'db.php';
        $sql = "SELECT a.id, a.a_nombre, a.a_descripcion, b.p_nombre, a.a_fecini, a.a_fecfin, a.a_monto_mensual, a.a_monto_clase, a.a_cupo, a.a_limite_cancelacion, a.a_profesor FROM " . get_db() . ".actividad AS a INNER JOIN " . get_db() . ".profesor AS b ON a.a_profesor = b.id WHERE a.id = '" . $id . "'";
        $disciplina = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $disciplina;
    }

    function update_disciplina($id, $a_nombre, $a_descripcion, $a_profesor, $a_fecini, $a_fecfin, $a_monto_mensual, $a_monto_clase, $a_cupo, $a_limite_cancelacion)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".actividad SET a_nombre = '" . strtoupper($a_nombre) . "', a_descripcion = '" . $a_descripcion . "', a_profesor = '" . $a_profesor . "', a_fecini = '" . $a_fecini . "', a_fecfin = '" . $a_fecfin . "', a_monto_mensual = '" . $a_monto_mensual . "', a_monto_clase = '" . $a_monto_clase . "', a_cupo = '" . $a_cupo . "', a_limite_cancelacion = '" . $a_limite_cancelacion . "' WHERE id = '" . $id . "'";
        consola($sql);
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function get_listado_disciplinas()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.a_nombre, a.a_profesor, b.p_nombre, a.a_fecini, a.a_fecfin, a.a_monto_mensual, a.a_monto_clase, a.a_cupo, a.a_limite_cancelacion FROM " . get_db() . ".actividad AS a INNER JOIN " . get_db() . ".profesor AS b ON a.a_profesor = b.id");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>$ " . moneda($f[6]) . "</td>";
            $tabla .= "<td>$ " . moneda($f[7]) . "</td>";
            $tabla .= "<td>" . $f[8] . "</td>";
            $tabla .= "<td>" . $f[9] . "</td>";
            $tabla .= "<td><a class='mr-2' href='disciplina_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }
}

/* CLASES */ {

    function get_info_clase($id)
    {
        include 'db.php';
        $clase = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, b.a_nombre, a.c_cupo, a.c_dia, a.c_horaini, a.c_horafin, a.c_actividad, (SELECT COUNT(c.id) FROM " . get_db() . ".socio_clase AS c WHERE c.sc_clase = a.id) FROM " . get_db() . ".clase AS a INNER JOIN " . get_db() . ".actividad AS b ON a.c_actividad = b.id WHERE a.id = '" . $id . "'"));
        return $clase;
    }

    function get_info_clase_socio($id)
    {
        include 'db.php';
        $clase = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, b.id, c.a_nombre, b.c_dia, b.c_horaini, b.c_horafin, a.sc_estado, c.id, a.sc_monto, a.sc_socio FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.id = '" . $id . "'"));
        return $clase;
    }

    function get_listado_clases($id)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.c_dia, a.c_horaini, a.c_horafin, a.c_cupo, (SELECT COUNT(b.id) FROM " . get_db() . ".socio_clase AS b WHERE b.sc_clase = a.id) FROM " . get_db() . ".clase AS a WHERE a.c_actividad = '" . $id . "'");
        while ($f = mysqli_fetch_array($r)) {
            $clase = set_class_tabla_clases($f[4], $f[5]);
            $tabla .= "<tr class='" . $clase . "'>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td><a class='mr-2' href='clases_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function listado_clases_socio($sc_socio)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.a_nombre, b.c_dia, b.c_horaini, b.c_horafin, a.sc_monto, a.sc_estado FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . $sc_socio . "' AND b.c_dia >= '" . date('Y-m-d') . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>$ " . $f[5] . "</td>";
            $tabla .= "<td>" . get_badge_estado_clase($f[6]) . "</td>";
            $tabla .= "<td><a class='mr-2' href='clases_socio_info.php?id=" . $f[0] . "'><i style='font-size: 20px;' class='fas fa-search'></i></a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function set_class_tabla_clases($cupos, $reservas)
    {
        $porcentaje = round((($reservas * 100) / $cupos));
        if ($porcentaje == 100) {
            return 'table-secondary';
        }

        if (($porcentaje >= 0) && ($porcentaje < 50)) {
            return 'table-success';
        }

        if (($porcentaje >= 50) && ($porcentaje < 75)) {
            return 'table-warning';
        }

        if (($porcentaje >= 75) && ($porcentaje < 100)) {
            return 'table-danger';
        }
    }

    function get_badge_estado_clase($estado)
    {
        $badge = "";
        if ($estado == "GENERADA") {
            $badge = '<span class="badge badge-primary">Generada</span>';
        }
        if ($estado == "IMPAGA") {
            $badge = '<span class="badge badge-danger">Impaga</span>';
        }
        if ($estado == "PAGA") {
            $badge = '<span class="badge badge-success">Paga</span>';
        }
        if ($estado == "CANCELADA") {
            $badge = '<span class="badge badge-secondary">Cancelada</span>';
        }
        return $badge;
    }

    function insert_clase($c_actividad, $c_cupo, $c_dia, $c_horaini, $c_horafin)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".clase (c_actividad, c_cupo, c_dia, c_horaini, c_horafin) VALUES (" . $c_actividad . ", " . $c_cupo . ", '" . $c_dia . "', '" . $c_horaini . "', '" . $c_horafin . "')";
        consola($sql);
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function verificacion_clase($c_actividad, $c_dia, $c_horaini, $c_horafin)
    {
        include 'db.php';
        $sql = "SELECT COUNT(a.id) FROM " . get_db() . ".clase AS a WHERE a.c_actividad = '" . $c_actividad . "' AND a.c_dia = '" . $c_dia . "' AND a.c_horaini = '" . $c_horaini . "' AND a.c_horafini = '" . $c_horafin . "'";
        consola($sql);
        $control = mysqli_fetch_array(mysqli_query($conexion, $sql));
        if ($control[0] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function generacion_dias_clases($c_actividad, $desde, $hasta, $dia, $c_horaini, $c_horafin, $c_cupo)
    {
        include 'db.php';

        $begin = new DateTime(date('Y-m-d', strtotime($desde)));
        $end = new DateTime(date('Y-m-d', strtotime($hasta)));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $insertados = 0;
        $dias = 0;

        foreach ($period as $dt) {
            if ($dt->format("N") == $dia) {
                $dias++;
                $c_dia = $dt->format('Y-m-d');
                if (verificacion_clase($c_actividad, $c_dia, $c_horaini, $c_horafin)) {
                    if (insert_clase($c_actividad, $c_cupo, $c_dia, $c_horaini, $c_horafin)) {
                        $insertados++;
                    }
                }
            }
        }

        if ($dias == $insertados) {
            return true;
        } else {
            return false;
        }
    }

    function get_listado_reservas_clase($id)
    {
        include 'db.php';
        $tabla = "";
        $orden = 1;
        $sql = "SELECT a.id,CONCAT( b.s_apellido, ', ', b.s_nombre), b.s_documento, b.s_celular, a.sc_generacion, d.id, a.sc_socio FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".socio AS b ON a.sc_socio = b.id INNER JOIN " . get_db() . ".clase AS c ON a.sc_clase = c.id INNER JOIN " . get_db() . ".actividad AS d ON c.c_actividad = d.id WHERE a.sc_clase = '" . $id . "' ORDER BY b.s_apellido, b.s_nombre ASC";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $orden . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $deuda_acumulada = mysqli_fetch_array(mysqli_query($conexion, "SELECT SUM(a.sc_monto) FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . $f[6] . "' AND c.id = '" . $f[5] . "' AND a.sc_estado = 'IMPAGA'"));
            $tabla .= "<td>$ " . moneda($deuda_acumulada[0]) . "</td>";
            $tabla .= "<td><a class='mr-2' href='delete_reserva_clase.php?id=" . $f[0] . "&clase=" . $id . "'><i style='font-size: 20px;' class='fas fa-trash'></i></a></td>";
            $orden++;
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function insert_reserva_clase($sc_socio, $sc_clase, $sc_abono)
    {
        include 'db.php';
        $sc_monto = get_monto_clase($sc_clase);
        $sql = "INSERT INTO " . get_db() . ".socio_clase (sc_socio, sc_clase, sc_abono, sc_monto) VALUES ('" . $sc_socio . "', '" . $sc_clase . "', '" . $sc_abono . "', '" . $sc_monto . "')";
        if (mysqli_query($conexion, $sql)) {
            return true;
            //            if(decrementar_cupo_clase($sc_clase)){
            //                return true;
            //            }else{
            //                return false;
            //            }
        } else {
            return false;
        }
    }

    function get_monto_clase($sc_clase)
    {
        include 'db.php';
        $sql = "SELECT b.a_monto_clase FROM " . get_db() . ".clase AS a INNER JOIN " . get_db() . ".actividad AS b ON a.c_actividad = b.id WHERE a.id = '" . $sc_clase . "'";
        $monto = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $monto[0];
    }

    function delete_reserva_clase($id, $sc_clase)
    {
        include 'db.php';
        $sql = "DELETE FROM " . get_db() . ".socio_clase WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
            //            if(incrementar_cupo_clase($sc_clase)){
            //                return true;
            //            }else{
            //                return false;
            //            }
        } else {
            return false;
        }
    }

    function decrementar_cupo_clase($id)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".clase SET c_cupo = c_cupo - 1 WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function incrementar_cupo_clase($id)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".clase SET c_cupo = c_cupo + 1 WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function get_clases_socios($socio_id)
    {
        include 'db.php';
        //$ejm = "{title: 'YOGA', start: '2020-09-01T12:00:00', end: '2020-09-01T14:00:00'}";
        $clases = "";
        $contador = 0;
        $r = mysqli_query($conexion, "SELECT a.id, a.sc_clase, b.c_dia, b.c_horaini, b.c_horafin, c.a_nombre FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . $socio_id . "'");

        while ($f = mysqli_fetch_array($r)) {
            if ($contador == 0) {
                $clases .= "{ id: '" . $f[1] . "', title: '" . $f[5] . "', start: '" . $f[2] . "T" . $f[3] . "', end: '" . $f[2] . "T" . $f[4] . "'}";
            } else {
                $clases .= ", { id: '" . $f[1] . "', title: '" . $f[5] . "', start: '" . $f[2] . "T" . $f[3] . "', end: '" . $f[2] . "T" . $f[4] . "'}";
            }
            $contador++;
        }
        return $clases;
    }

    function get_clases()
    {
        include 'db.php';
        //$ejm = "{title: 'YOGA', start: '2020-09-01T12:00:00', end: '2020-09-01T14:00:00'}";
        $clases = "";
        $contador = 0;
        $r = mysqli_query($conexion, "SELECT a.id, a.c_dia, a.c_horaini, a.c_horafin, b.a_nombre, a.c_cupo, (SELECT COUNT(c.id) FROM " . get_db() . ".socio_clase AS c WHERE c.sc_clase = a.id) FROM " . get_db() . ".clase AS a INNER JOIN " . get_db() . ".actividad AS b ON a.c_actividad = b.id");

        while ($f = mysqli_fetch_array($r)) {
            $color = get_color_evento_clase($f[5], $f[6]);


            if ($contador == 0) {
                $clases .= "{ id: '" . $f[0] . "', title: '" . $f[4] . "', start: '" . $f[1] . "T" . $f[2] . "', end: '" . $f[1] . "T" . $f[3] . "', color: '" . $color . "'}";
            } else {
                $clases .= ", { id: '" . $f[0] . "', title: '" . $f[4] . "', start: '" . $f[1] . "T" . $f[2] . "', end: '" . $f[1] . "T" . $f[3] . "', color: '" . $color . "'}";
            }
            $contador++;
        }
        return $clases;
    }

    function get_color_evento_clase($cupos, $reservas)
    {
        $porcentaje = round((($reservas * 100) / $cupos));
        if ($porcentaje == 100) {
            return 'red';
        }

        if (($porcentaje >= 0) && ($porcentaje < 50)) {
            return '#006700';
        }

        if (($porcentaje >= 50) && ($porcentaje < 75)) {
            return '#cccc00';
        }

        if (($porcentaje >= 75) && ($porcentaje < 100)) {
            return '#bc0000';
        }
    }

    function imputar_clase_paga($c_clase, $comprobante)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".socio_clase SET sc_comprobante = '" . $comprobante . "', sc_estado = 'PAGA' WHERE id = '" . $c_clase . "'";
        if (mysqli_query($conexion, $sql)) {
            auditoria('CLASE', 'IMPUTACION DE CLASE. ID: ' . $c_clase . '. COMPROBANTE: ' . $comprobante);
            return true;
        } else {
            return false;
        }
    }
}

/* FULL CALENDAR */ {

    function get_fullcalendar()
    {
        include 'db.php';
        $fullcalendar = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".fullcalendar WHERE id = 1"));
        return $fullcalendar;
    }
}

/* TESORERIA */ {

    function get_tabla_diaria_tesoreria()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.c_generacion, b.forpag_nombre, a.c_monto FROM " . get_db() . ".comprobante AS a INNER JOIN " . get_db() . ".forpag AS b ON a.c_forpag = b.id WHERE a.c_generacion = ".date('Y-m-d')." ORDER BY a.c_generacion DESC");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>$ " . moneda($f[2]) . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_cuotas_impagas_socio($id_socio)
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.c_nombre, a.c_periodo, a.c_monto FROM " . get_db() . ".cuota AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.c_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id LEFT JOIN " . get_db() . ".aux_tesoreria AS d ON a.id = d.t_id WHERE d.t_id IS NULL AND a.c_socio = '" . $id_socio . "' AND a.c_comprobante = 0 AND a.c_anulada = 'NO'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>$ " . moneda($f[3]) . "</td>";
            $tabla .= "<td><a class='bnt btn-sm btn-success' href='tesoreria_agregar.php?t_socio=" . $id_socio . "&t_concepto=" . urlencode('Categoria: ' . $f[1] . '. Periodo: ' . $f[2]) . "&t_tipo=CUOTA&t_id=" . $f[0] . "&t_monto=" . $f[3] . "'>Agregar</a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_clases_impagas_socio($id_socio)
    {
        include 'db.php';
        $tabla = "";
        $sql = "SELECT a.id, c.a_nombre, b.c_dia, a.sc_monto FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id LEFT JOIN " . get_db() . ".aux_tesoreria AS d ON a.id = d.t_id WHERE d.t_id IS NULL AND a.sc_estado = 'IMPAGA' AND a.sc_comprobante is null AND a.sc_socio = '" . $id_socio . "'";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>$ " . moneda($f[3]) . "</td>";
            $tabla .= "<td><a class='bnt btn-sm btn-success' href='tesoreria_agregar.php?t_socio=" . $id_socio . "&t_concepto=" . urlencode('Clase: ' . $f[1] . '. Fecha: ' . $f[2]) . "&t_tipo=CLASE&t_id=" . $f[0] . "&t_monto=" . $f[3] . "'>Agregar</a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function insert_item_tesoreria($t_socio, $t_concepto, $t_tipo, $t_id, $t_monto, $t_usuario)
    {
        include 'db.php';
        $sql = "INSERT INTO " . get_db() . ".aux_tesoreria (t_socio, t_concepto, t_tipo, t_id, t_monto, t_usuario) VALUES ('" . $t_socio . "', '" . $t_concepto . "', '" . $t_tipo . "', '" . $t_id . "', '" . $t_monto . "', '" . $t_usuario . "')";

        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function delete_item_tesoreria($id)
    {
        include 'db.php';
        $sql = "DELETE FROM " . get_db() . ".aux_tesoreria WHERE id = '" . $id . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function tabla_tesoreria_cobranza()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, a.t_concepto, a.t_monto, a.t_socio FROM " . get_db() . ".aux_tesoreria AS a WHERE a.t_usuario = '" . get_id_usuario() . "'");
        $total = 0;
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>$ " . moneda($f[2]) . "</td>";
            $total = $total + $f[2];
            $tabla .= "<td><center><a class='bnt btn-sm btn-danger' href='tesoreria_eliminar.php?id=" . $f[0] . "&socio=" . $f[3] . "'>Eliminar</a></center></td>";
            $tabla .= "</tr>";
        }

        $tabla .= "<tr class='font-weight-bold'>";
        $tabla .= "<td colspan=2>Total</td>";
        $tabla .= "<td id='total_cobranza'><center>$" . moneda($total) . "</center></td>";
        $tabla .= "</tr>";

        return $tabla;
    }

    function cancelar_cobranza()
    {
        include 'db.php';
        $sql = "DELETE FROM " . get_db() . ".aux_tesoreria WHERE t_usuario = '" . get_id_usuario() . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }
}

/* CHEQUES */ {

    function cheques_vencidos($tipo)
    {
        include 'db.php';
        $estilo = "success";
        $texto = "";
        $href = "#";
        $hoy = date('Y-m-d');

        $sql = "";
        if ($tipo == "PROPIOS") {
            $sql = "SELECT COUNT(a.id) FROM " . get_db() . ".[tb_cheque_p] AS a WHERE a.cp_pago < '" . $hoy . "' AND a.cp_estado = 'A PAGAR'";
        } else {
            $sql = "SELECT COUNT(a.id) FROM " . get_db() . ".[tb_cheque_t] AS a WHERE a.ct_deposito < '" . $hoy . "' AND a.ct_estado = 'A DEPOSITAR'";
        }
        $cantidad = mysqli_fetch_array(mysqli_query($conexion, $sql));

        if ($cantidad[0] > 0) {
            $estilo = "danger";
            if ($tipo == "PROPIOS") {
                $href = "cp_vencidos.php";
                $texto = "TIENE " . $cantidad[0] . " CHEQUES PROPIOS VENCIDOS";
            } else {
                $href = "ct_vencidos.php";
                $texto = "TIENE " . $cantidad[0] . " CHEQUES TERCEROS SIN DEPOSITAR";
            }
        } else {
            $estilo = "success";
            $href = "#";
            $texto = "No tiene cheques vencidos";
        }

        $div = "<div class='alert alert-" . $estilo . "'><a style='color:white;' href='" . $href . "'>" . $texto . "</a></div>";

        return $div;
    }

    function tabla_cheques_terceros_vencidos()
    {
        include 'db.php';
        $tabla = "<table id='table_cheques' style='font-size: 11px;' class='table table-sm table-bordered table-striped'><thead><tr>";

        $tabla .= "<th>#</th>";
        $tabla .= "<th>Ingreso</th>";
        $tabla .= "<th>Cliente</th>";
        $tabla .= "<th># Factura</th>";
        $tabla .= "<th>Deposito</th>";
        $tabla .= "<th>Banco Emision</th>";
        $tabla .= "<th># Cheque</th>";
        $tabla .= "<th>Titular</th>";
        $tabla .= "<th>Monto</th>";
        $tabla .= "<th>Estado</th>";
        $tabla .= "<th>Banco Depositado</th>";
        $tabla .= "<th>Endoso</th>";
        $tabla .= "<th>Destinatario</th>";
        $tabla .= "<th></th>";

        $tabla .= "</tr></thead><tbody>";
        $r = mysqli_query($conexion, "SELECT id, ct_ingreso, ct_cliente, ct_factura, ct_deposito, ct_banco_emision, ct_numero, ct_titular, ct_monto, ct_estado, ct_banco_depositado, ct_endoso, ct_destinatario_endoso FROM " . get_db() . ".[tb_cheque_t] WHERE ct_ingreso < '" . date('Y-m-d') . "' AND ct_estado = 'A DEPOSITAR'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[1])) . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            if ($f[4] == null) {
                $tabla .= "<td></td>";
            } else {
                $tabla .= "<td>" . date('d/m/Y', strtotime($f[4])) . "</td>";
            }
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>" . $f[7] . "</td>";
            $tabla .= "<td>$ " . moneda($f[8]) . "</td>";
            $tabla .= "<td>" . $f[9] . "</td>";
            $tabla .= "<td>" . $f[10] . "</td>";
            if ($f[11] == null) {
                $tabla .= "<td></td>";
            } else {
                $tabla .= "<td>" . date('d/m/Y', strtotime($f[11])) . "</td>";
            }
            $tabla .= "<td>" . $f[12] . "</td>";
            $tabla .= '<td><div class="dropdown"><button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cogs"></i></button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if ($f[9] == "A DEPOSITAR") {
                $tabla .= '<a class="dropdown-item" href="ct_depositar.php?id=' . $f[0] . '">Depositar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_endosar.php?id=' . $f[0] . '">Endosar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            if ($f[9] == "DEPOSITADO") {
                $tabla .= '<a class="dropdown-item" href="ct_adepositar.php?id=' . $f[0] . '">A Depositar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }

            if ($f[9] == "ENDOSADO") {
                $tabla .= '<a class="dropdown-item" href="ct_adepositar.php?id=' . $f[0] . '">A Depositar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }

            $tabla .= '</div></div></td>';

            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        return $tabla;
    }

    function tabla_cheques_propios_vencidos()
    {
        include 'db.php';
        $tabla = "<table id='table_cheques' class='table table-sm table-bordered table-striped'><thead><tr>";

        $tabla .= "<th>#</th>";
        $tabla .= "<th>Entrega</th>";
        $tabla .= "<th>Proveedor</th>";
        $tabla .= "<th># Factura</th>";
        $tabla .= "<th>Pago</th>";
        $tabla .= "<th>Banco Emision</th>";
        $tabla .= "<th># Cheque</th>";
        $tabla .= "<th>Monto</th>";
        $tabla .= "<th>Estado</th>";
        $tabla .= "<th></th>";

        $tabla .= "</tr></thead><tbody>";
        $r = mysqli_query($conexion, "SELECT id, cp_entrega, cp_proveedor, cp_factura, cp_pago, cp_banco_emision, cp_numero, cp_monto, cp_estado FROM " . get_db() . ".[tb_cheque_p] WHERE cp_entrega < '" . date('Y-m-d') . "' AND cp_estado = 'A PAGAR'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[1])) . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[4])) . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>$ " . moneda($f[7]) . "</td>";
            $tabla .= "<td>" . $f[8] . "</td>";
            $tabla .= '<td><div class="dropdown"><button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cogs"></i></button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if ($f[8] == 'A PAGAR') {
                $tabla .= '<a class="dropdown-item" href="cp_pagar.php?id=' . $f[0] . '">Pagar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="cp_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="cp_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            if ($f[8] == 'PAGADO') {
                $tabla .= '<a class="dropdown-item" href="cp_apagar.php?id=' . $f[0] . '">A Pagar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="cp_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="cp_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            $tabla .= '</div></div></td>';
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        return $tabla;
    }

    function get_info_cheque_tercero($id)
    {
        include 'db.php';
        $cheque = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".[tb_cheque_t] WHERE id = '" . $id . "'"));
        return $cheque;
    }

    function get_info_cheque_propio($id)
    {
        include 'db.php';
        $cheque = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".[tb_cheque_p] WHERE id = '" . $id . "'"));
        return $cheque;
    }


    function monto_cheques($tabla, $desde, $hasta)
    {
        include 'db.php';
        $sql = "";
        if ($tabla == "PROPIO") {
            $sql = "SELECT SUM(cp_monto) FROM " . get_db() . ".[tb_cheque_p] WHERE cp_pago BETWEEN '" . $desde . "' AND '" . $hasta . "' AND cp_estado = 'A PAGAR'";
        } else {
            $sql = "SELECT SUM(ct_monto) FROM " . get_db() . ".[tb_cheque_t] WHERE ct_deposito BETWEEN '" . $desde . "' AND '" . $hasta . "' AND ct_estado = 'A DEPOSITAR'";
        }
        $monto = mysqli_fetch_array(mysqli_query($conexion, $sql));

        if ($monto[0] == null) {
            return '$ ' . moneda(0);
        } else {
            return '$ ' . moneda($monto[0]);
        }
    }

    function cantidad_cheques($tabla, $desde, $hasta)
    {
        include 'db.php';
        $sql = "";
        if ($tabla == "PROPIO") {
            $sql = "SELECT COUNT(id) FROM " . get_db() . ".[tb_cheque_p] WHERE cp_pago BETWEEN '" . $desde . "' AND '" . $hasta . "' AND cp_estado = 'A PAGAR'";
        } else {
            $sql = "SELECT COUNT(id) FROM " . get_db() . ".[tb_cheque_t] WHERE ct_deposito BETWEEN '" . $desde . "' AND '" . $hasta . "' AND ct_estado = 'A DEPOSITAR'";
        }
        $cantidad = mysqli_fetch_array(mysqli_query($conexion, $sql));

        return $cantidad[0];
    }

    function tabla_cheques_propios($desde, $hasta)
    {
        include 'db.php';
        $tabla = "<table id='table_cheques' style='font-size:12px;' class='table table-sm table-bordered table-striped'><thead><tr>";

        $tabla .= "<th>#</th>";
        $tabla .= "<th>Entrega</th>";
        $tabla .= "<th>Proveedor</th>";
        $tabla .= "<th># Factura</th>";
        $tabla .= "<th>Pago</th>";
        $tabla .= "<th>Banco Emision</th>";
        $tabla .= "<th># Cheque</th>";
        $tabla .= "<th>Monto</th>";
        $tabla .= "<th>Estado</th>";
        $tabla .= "<th></th>";

        $tabla .= "</tr></thead><tbody>";
        $r = mysqli_query($conexion, "SELECT id, cp_entrega, cp_proveedor, cp_factura, cp_pago, cp_banco_emision, cp_numero, cp_monto, cp_estado FROM " . get_db() . ".[tb_cheque_p] WHERE cp_entrega BETWEEN '" . $desde . "' AND '" . $hasta . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[1])) . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[4])) . "</td>";
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>$ " . moneda($f[7]) . "</td>";
            $tabla .= "<td>" . $f[8] . "</td>";
            $tabla .= '<td><div class="dropdown"><button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cogs"></i></button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if ($f[8] == 'A PAGAR') {
                $tabla .= '<a class="dropdown-item" href="cp_pagar.php?id=' . $f[0] . '">Pagar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="cp_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="cp_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            if ($f[8] == 'PAGADO') {
                $tabla .= '<a class="dropdown-item" href="cp_apagar.php?id=' . $f[0] . '">A Pagar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="cp_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="cp_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            $tabla .= '</div></div></td>';
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        return $tabla;
    }

    function tabla_cheques_terceros($desde, $hasta)
    {
        include 'db.php';
        $tabla = "<table id='tabla_cheques' style='font-size:12px;' class='table table-sm table-bordered table-striped'><thead><tr>";

        $tabla .= "<th>#</th>";
        $tabla .= "<th>Ingreso</th>";
        $tabla .= "<th>Cliente</th>";
        $tabla .= "<th># Factura</th>";
        $tabla .= "<th>Deposito</th>";
        $tabla .= "<th>Banco Emision</th>";
        $tabla .= "<th># Cheque</th>";
        $tabla .= "<th>Titular</th>";
        $tabla .= "<th>Monto</th>";
        $tabla .= "<th>Estado</th>";
        $tabla .= "<th>Banco Depositado</th>";
        $tabla .= "<th>Endoso</th>";
        $tabla .= "<th>Destinatario</th>";
        $tabla .= "<th></th>";

        $tabla .= "</tr></thead><tbody>";
        $r = mysqli_query($conexion, "SELECT id, ct_ingreso, ct_cliente, ct_factura, ct_deposito, ct_banco_emision, ct_numero, ct_titular, ct_monto, ct_estado, ct_banco_depositado, ct_endoso, ct_destinatario_endoso FROM " . get_db() . ".[tb_cheque_t] WHERE ct_ingreso BETWEEN '" . $desde . "' AND '" . $hasta . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . date('d/m/Y', strtotime($f[1])) . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            if ($f[4] == null) {
                $tabla .= "<td></td>";
            } else {
                $tabla .= "<td>" . date('d/m/Y', strtotime($f[4])) . "</td>";
            }
            $tabla .= "<td>" . $f[5] . "</td>";
            $tabla .= "<td>" . $f[6] . "</td>";
            $tabla .= "<td>" . $f[7] . "</td>";
            $tabla .= "<td>$ " . moneda($f[8]) . "</td>";
            $tabla .= "<td>" . $f[9] . "</td>";
            $tabla .= "<td>" . $f[10] . "</td>";
            if ($f[11] == null) {
                $tabla .= "<td></td>";
            } else {
                $tabla .= "<td>" . date('d/m/Y', strtotime($f[11])) . "</td>";
            }
            $tabla .= "<td>" . $f[12] . "</td>";
            $tabla .= '<td><div class="dropdown"><button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cogs"></i></button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if ($f[9] == "A DEPOSITAR") {
                $tabla .= '<a class="dropdown-item" href="ct_depositar.php?id=' . $f[0] . '">Depositar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_endosar.php?id=' . $f[0] . '">Endosar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }
            if ($f[9] == "DEPOSITADO") {
                $tabla .= '<a class="dropdown-item" href="ct_adepositar.php?id=' . $f[0] . '">A Depositar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }

            if ($f[9] == "ENDOSADO") {
                $tabla .= '<a class="dropdown-item" href="ct_adepositar.php?id=' . $f[0] . '">A Depositar</a>';
                $tabla .= '<hr>';
                $tabla .= '<a class="dropdown-item" href="ct_modificar.php?id=' . $f[0] . '">Modificar</a>';
                $tabla .= '<a class="dropdown-item" href="ct_eliminar.php?id=' . $f[0] . '">Eliminar</a>';
            }

            $tabla .= '</div></div></td>';

            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        return $tabla;
    }
}

/* CONTABLE */ {
    function tabla_ingresos($inicio, $fin){
        include 'db.php';
        $tabla = "<table class='table table-bordered table-striped table-sm'><thead><tr>";
        $tabla .= "<th>Generacion</th>";
        $tabla .= "<th>Forpag</th>";
        $tabla .= "<th>Caja</th>";
        $tabla .= "<th>Monto</th>";
        $tabla .= "</thead><tbody>";
        $sql = "SELECT a.c_generacion, b.forpag_nombre, c.c_nombre, a.c_monto FROM ".get_db().".comprobante AS a INNER JOIN ".get_db().".forpag AS b ON a.c_forpag = b.id INNER JOIN ".get_db().".caja AS c ON a.c_caja = c.id WHERE a.c_fecha BETWEEN '{$inicio}' AND  '{$fin}'";
        $total = 0;
        $r = mysqli_query($conexion, $sql);        
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>{$f[0]}</td>";
            $tabla .= "<td>{$f[1]}</td>";
            $tabla .= "<td>{$f[2]}</td>";
            $tabla .= "<td>$ ".moneda($f[3])."</td>";
            $tabla .= "</tr>";
            $total += $f[3];
        }

        $tabla .= "<tr class='font-weight-bold'>";
        $tabla .= "<td colspan=3>Total</td>";
        $tabla .= "<td id='total_cobranza'><center>$" . moneda($total) . "</center></td>";
        $tabla .= "</tr></tbody></table>";

        return $tabla;

    }
}
