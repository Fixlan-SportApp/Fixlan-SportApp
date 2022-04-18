<?php



/* SEGURIDAD */ {

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

    function consola($contenido)
    {
        echo '<script>console.log("' . $contenido . '");</script>';
    }

    function get_db(){
        return $_COOKIE['CL_DB'];
    }

    function get_name_club(){
        include 'db.php';
        $club = mysqli_fetch_array(mysqli_query($conexion, "SELECT b.c_nombre FROM {$sportapp_db}.tb_cliente AS a INNER JOIN {$sportapp_db}.tb_club AS b ON a.c_club = b.id WHERE a.c_email = '".get_usuario()."'"));
        return $club[0];
    }

    function get_logo()
    {
        include 'db.php';
        $logo = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.c_icon_mime, a.c_icon_data, a.c_logo_mime, a.c_logo_data FROM " . get_db() . ".club AS a WHERE a.id = 1"));
        return $logo;
    }

    function get_fullcalendar()
    {
        include 'db.php';
        $fullcalendar = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".fullcalendar WHERE id = 1"));
        return $fullcalendar;
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

    function get_access_token_mp(){
        include 'db.php';
        $access_token = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_access_token_mp FROM ".get_db().".club WHERE id = '1'"));
        return $access_token[0];
    }

    function get_dominio_retorno_mp(){
        include 'db.php';
        $dominio_retorno = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_dominio_retorno_mp FROM ".get_db().".club WHERE id = '1'"));
        return $dominio_retorno[0];
    }
}

/* INICIO DE SESION */{
    function get_login($correo, $password)
    {
        include 'db.php';
        $sql = "SELECT COUNT(a.id) FROM tb_cliente AS a WHERE a.c_email = '" . $correo . "' AND a.c_password = '" . md5($password) . "' AND a.c_estado = 'HABILITADO'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

    function set_token($usuario)
    {
        include 'db.php';
        $length = 50;
        $token = bin2hex(random_bytes($length));
        mysqli_query($conexion, "UPDATE {$sportapp_db}.tb_cliente SET c_token = '" . $token . "' WHERE c_email = '" . $usuario . "'");
        $_SESSION['SVCGE_TOKEN'] = $token;
    }

    function get_token($usuario)
    {
        include 'db.php';
        $sql = "SELECT a.c_token FROM {$sportapp_db}.tb_cliente AS a WHERE a.c_email = '" . $usuario . "'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

    function get_db_usuario($usuario)
    {
        include 'db.php';
        $sql = "SELECT a.c_db FROM {$sportapp_db}.tb_cliente AS a WHERE a.c_email = '" . $usuario . "' AND a.c_estado = 'HABILITADO'";
        $count = mysqli_fetch_array(mysqli_query($conexion, $sql));
        return $count[0];
    }

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

/* USUARIO */ {

    function get_usuario()
    {
        return $_COOKIE['CL_USER'];
    }

    function get_id_usuario()
    {
        include 'db.php';
        $id = mysqli_fetch_array(mysqli_query($conexion, "SELECT c_socio FROM {$sportapp_db}.tb_cliente WHERE c_email = '" . get_usuario() . "'"));
        return $id[0];
    }

    function get_info_socio($id)
    {
        include 'db.php';
        $socio = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio WHERE id = '" . $id . "'"));
        return $socio;
    }

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
    
    function check_is_socio($dni)
    {
        include 'db.php';
        $socio = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio WHERE s_documento = '" . $dni . "'"));
        return $socio;
    }

    function get_socio_by_dni($dni)
    {
        include 'db.php';
        $sql = "SELECT s.id, s.s_apellido as apellido, s.s_nombre as nombre, 
                       s.s_documento as documento, s.meses_adeudados, s.monto_adeudado,
                       e.e_nombre as estado
                FROM " . get_db() . ".socio s
                    INNER JOIN estado e on e.id = s.s_estado
                WHERE s_documento = '" . $dni . "'";
        $socio = mysqli_fetch_array(mysqli_query($conexion, $sql), MYSQLI_ASSOC);
        return $socio;
    }

}

/* ACTIVIDADES */{
    function get_info_actividad($id)
    {
        include 'db.php';
        $actividad = mysqli_fetch_array(mysqli_query($conexion, "SELECT * FROM " . get_db() . ".socio_categoria WHERE id = '" . $id . "'"));
        return $actividad;
    }

    function get_info_detallada_actividad($id)
    {
        include 'db.php';
        $datos = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, a.sc_socio, b.s_apellido + ', ' + b.s_nombre, c.sc_nombre, d.c_nombre, e.forpag_nombre, f.frepag_nombre, g.b_nombre, h.c_nombre, i.t_nombre, c.sc_grupofliar FROM ".get_db().".socio_categoria AS a INNER JOIN ". get_db() .".socio AS b ON a.sc_socio = b.id INNER JOIN ". get_db() .".subcategoria AS c ON a.sc_subcategoria = c.id INNER JOIN ". get_db() .".categoria AS d ON c.sc_categoria = d.id INNER JOIN ". get_db() .".forpag AS e ON a.sc_forpag = e.id INNER JOIN ". get_db() .".frepag AS f ON a.sc_frepag = f.id INNER JOIN ". get_db() .".beca AS g ON a.sc_beca = g.id INNER JOIN ". get_db() .".convenio AS h ON a.sc_convenio = h.id INNER JOIN ". get_db() .".tarjeta AS i ON a.sc_tarjeta = i.id WHERE a.id = '" . $id . "'"));
        return $datos;
    }

    function get_listado_actividades_socio()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.c_nombre, b.sc_nombre, d.forpag_nombre, e.frepag_nombre, f.b_nombre, g.c_nombre, a.sc_estado FROM " . get_db() . ".socio_categoria AS a INNER JOIN " . get_db() . ".subcategoria AS b ON a.sc_subcategoria = b.id INNER JOIN " . get_db() . ".categoria AS c ON b.sc_categoria = c.id INNER JOIN " . get_db() . ".forpag AS d ON a.sc_forpag = d.id INNER JOIN " . get_db() . ".frepag AS e ON a.sc_frepag = e.id INNER JOIN " . get_db() . ".beca AS f ON a.sc_beca = f.id INNER JOIN " . get_db() . ".convenio AS g ON a.sc_convenio = g.id WHERE a.sc_socio = '" . get_id_usuario() . "'");
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
            $tabla .= "<td><a href='actividad_info.php?id=".$f[0]."' class='btn btn-sm btn-primary'>Ver</a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
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
}

/* CLASES */ {

    function get_clases()
    {
        include 'db.php';
        //$ejm = "{title: 'YOGA', start: '2020-09-01T12:00:00', end: '2020-09-01T14:00:00'}";
        $clases = "";
        $contador = 0;
        $r = mysqli_query($conexion, "SELECT a.id, a.c_dia, a.c_horaini, a.c_horafin, b.a_nombre, a.c_cupo, (SELECT COUNT(c.id) FROM " . get_db() . ".socio_clase AS c WHERE c.sc_clase = a.id) FROM " . get_db() . ".clase AS a INNER JOIN " . get_db() . ".actividad AS b ON a.c_actividad = b.id WHERE a.c_dia > '".date('Y-m-d')."'");

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


    function listado_clases_socio()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.a_nombre, b.c_dia, b.c_horaini, b.c_horafin, a.sc_monto, a.sc_estado FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . get_id_usuario() . "' AND b.c_dia >= '" . date('Y-m-d') . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "<td>$ " . $f[5] . "</td>";
            $tabla .= "<td>" . get_badge_estado_clase($f[6]) . "</td>";
            $tabla .= "<td><a href='clase_pagar.php?id=".$f[0]."' class='btn btn-sm btn-success'>Pagar</a></td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function listado_clases_socio_home()
    {
        include 'db.php';
        $tabla = "";
        $r = mysqli_query($conexion, "SELECT a.id, c.a_nombre, b.c_dia, b.c_horaini, b.c_horafin FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . get_id_usuario() . "' AND b.c_dia >= '" . date('Y-m-d') . "'");
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $f[0] . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $tabla .= "<td>" . $f[2] . "</td>";
            $tabla .= "<td>" . $f[3] . "</td>";
            $tabla .= "<td>" . $f[4] . "</td>";
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function get_badge_estado_clase($estado)
    {
        $badge = "";
        if ($estado == "GENERADA") {
            $badge = '<h5><span class="badge badge-primary">Generada</span></h5>';
        }
        if ($estado == "IMPAGA") {
            $badge = '<h5><span class="badge badge-danger">Impaga</span></h5>';
        }
        if ($estado == "PAGA") {
            $badge = '<h5><span class="badge badge-success">Paga</span></h5>';
        }
        if ($estado == "CANCELADA") {
            $badge = '<h5><span class="badge badge-secondary">Cancelada</span></h5>';
        }
        return $badge;
    }

    function get_clases_socios()
    {
        include 'db.php';
        //$ejm = "{title: 'YOGA', start: '2020-09-01T12:00:00', end: '2020-09-01T14:00:00'}";
        $clases = "";
        $contador = 0;
        $r = mysqli_query($conexion, "SELECT a.id, a.sc_clase, b.c_dia, b.c_horaini, b.c_horafin, c.a_nombre FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".clase AS b ON a.sc_clase = b.id INNER JOIN " . get_db() . ".actividad AS c ON b.c_actividad = c.id WHERE a.sc_socio = '" . get_id_usuario() . "'");

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

    function get_info_clase($id)
    {
        include 'db.php';
        $clase = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, a.sc_socio, a.sc_clase, a.sc_abono, a.sc_monto, a.sc_generacion, a.sc_estado, a.sc_comprobante, c.a_nombre, b.c_dia, b.c_horaini, b.c_horafin FROM ". get_db() .".socio_clase AS a INNER JOIN ".get_db().".clase AS b ON a.sc_clase = b.id INNER JOIN ".get_db().".actividad AS c ON b.c_actividad = c.id WHERE a.id = " . $id));
        return $clase;
    }

    function get_clase($id)
    {
        include 'db.php';
        $clase = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.id, b.a_nombre, a.c_cupo, a.c_dia, a.c_horaini, a.c_horafin, a.c_actividad, (SELECT COUNT(c.id) FROM " . get_db() . ".socio_clase AS c WHERE c.sc_clase = a.id), b.a_limite_cancelacion FROM " . get_db() . ".clase AS a INNER JOIN " . get_db() . ".actividad AS b ON a.c_actividad = b.id WHERE a.id = '" . $id . "'"));
        return $clase;
    }

    function get_listado_reservas_clase($id)
    {
        include 'db.php';
        $tabla = "";
        $orden = 1;
        $sql = "SELECT a.id, b.s_apellido + ', ' + b.s_nombre, a.sc_socio FROM " . get_db() . ".socio_clase AS a INNER JOIN " . get_db() . ".socio AS b ON a.sc_socio = b.id WHERE a.sc_clase = '" . $id . "' ORDER BY b.s_apellido, b.s_nombre ASC";
        $r = mysqli_query($conexion, $sql);
        while ($f = mysqli_fetch_array($r)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $orden . "</td>";
            $tabla .= "<td>" . $f[1] . "</td>";
            $orden++;
            $tabla .= "</tr>";
        }
        return $tabla;
    }

    function check_clase_paga_socio($sc_socio, $sc_clase){
        include 'db.php';
        $control = mysqli_fetch_array(mysqli_query($conexion, "SELECT sc_estado FROM ".get_db().".socio_clase WHERE sc_socio = '".$sc_socio."' AND sc_clase = '".$sc_clase."'"));
        if($control[0] == 'PAGA'){
            return true;
        }else{
            return false;
        }
    }

    function get_id_socio_clase($sc_socio, $sc_clase){
        include 'db.php';
        $control = mysqli_fetch_array(mysqli_query($conexion, "SELECT id FROM ".get_db().".socio_clase WHERE sc_socio = '".$sc_socio."' AND sc_clase = '".$sc_clase."'"));
        return $control[0];
    }

    function insert_reserva_clase($sc_socio, $sc_clase, $sc_abono)
    {
        include 'db.php';
        $sc_monto = get_monto_clase($sc_clase);
        $sql = "INSERT INTO " . get_db() . ".socio_clase (sc_socio, sc_clase, sc_abono, sc_monto) VALUES ('" . $sc_socio . "', '" . $sc_clase . "', '" . $sc_abono . "', '" . $sc_monto . "')";
        if (mysqli_query($conexion, $sql)) {
            return true;
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

    function check_reserva_socio_clase($sc_socio, $sc_clase){
        include 'db.php';
        $control = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(id) FROM ".get_db().".socio_clase WHERE sc_socio = '".$sc_socio."' AND sc_clase = '".$sc_clase."'"));
        if($control[0] == 1){
            return true;
        }else{
            return false;
        }
    }

    function delete_reserva_clase($clase, $socio)
    {
        include 'db.php';
        $sql = "DELETE FROM " . get_db() . ".socio_clase WHERE sc_socio = '".$socio."' AND sc_clase = '".$clase."'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function imputar_clase_paga($c_clase, $comprobante)
    {
        include 'db.php';
        $sql = "UPDATE " . get_db() . ".socio_clase SET sc_comprobante = '" . $comprobante . "', sc_estado = 'PAGA' WHERE id = '" . $c_clase . "'";
        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }
}

/* CUOTAS */{
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
}

/* PAGO ONLINE */ {

    function check_comprobante_mp($pago_comprobante){
        include 'db.php';
        $control = mysqli_fetch_array(mysqli_query($conexion, "SELECT COUNT(a.id) FROM ".get_db().".[pago] AS a WHERE a.pago_comprobante = '".$pago_comprobante."'"));
        return $control[0];
    }

    function insert_pago_online($pago_socio, $pago_identificador, $pago_monto, $pago_comprobante, $pago_titulo, $pago_tipo, $pago_forpag, $pago_status, $pago_orderid){
        include 'db.php';
        $error = 0;
        $sql_insert = "INSERT INTO ".get_db().".[pago] (pago_socio, pago_identificador, pago_monto, pago_comprobante, pago_titulo, pago_tipo, pago_forpag, pago_status, pago_orderid, pago_comprobacion) VALUES ('".$pago_socio."', '".$pago_identificador."', '".$pago_monto."', '".$pago_comprobante."', '".$pago_titulo."', '".$pago_tipo."', '".$pago_forpag."', '".$pago_status."', '".$pago_orderid."', 'GENERADO')";
        if(mysqli_query($conexion, $sql_insert)){
            return true;
        }else{
            return false;
        }
    }

}

/* GRUPO FLIAR */ {
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
}

/* MOROSOS */ {

    // function check_is_socio_moroso($dni,$inicio,$fin){

    //     include 'db.php';
    //     $sql = "SELECT 
    //                 IFNULL(SUM(c.c_monto), 0) cuota
    //             FROM
    //                 " . get_db() . ".socio s
    //                     INNER JOIN
    //                 " . get_db() . ".cuota c
    //             WHERE
    //                 s.s_documento = '".$dni."'
    //                     AND c.c_comprobante = 0
    //                     AND c.c_anulada = 'NO'
    //                     AND c.c_periodo >= '".$inicio."'
    //                     AND c.c_periodo <= '".$fin."' ";
                        
    //     $socio_moroso = mysqli_fetch_assoc(mysqli_query($conexion, $sql));
        
    //     return (empty($socio_moroso))? true : (($socio_moroso['cuota'] > 0)? false : true);
    // }
}