<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Utility;

    function viewVue()
    {
        return view("app", ["root" => auth()->user()]);
    }

    function doReport()
    {
        if (request("tipo") == "1800") {
            $this->getReport1800();
        } else {
            $this->getReport3600();
        }
    }

    function getReport1800()
    {
        $hours = [
            "00:00:00",
            "00:30:00",
            "01:00:00",
            "01:30:00",
            "02:00:00",
            "02:30:00",
            "03:00:00",
            "03:30:00",
            "04:00:00",
            "04:30:00",
            "05:00:00",
            "05:30:00",
            "06:00:00",
            "06:30:00",
            "07:00:00",
            "07:30:00",
            "08:00:00",
            "08:30:00",
            "09:00:00",
            "09:30:00",
            "10:00:00",
            "10:30:00",
            "11:00:00",
            "11:30:00",
            "12:00:00",
            "12:30:00",
            "13:00:00",
            "13:30:00",
            "14:00:00",
            "14:30:00",
            "15:00:00",
            "15:30:00",
            "16:00:00",
            "16:30:00",
            "17:00:00",
            "17:30:00",
            "18:00:00",
            "18:30:00",
            "19:00:00",
            "19:30:00",
            "20:00:00",
            "20:30:00",
            "21:00:00",
            "21:30:00",
            "22:00:00",
            "22:30:00",
            "23:00:00",
            "23:30:00"
        ];
        $data = [];
        $login = 0;
        $acd = 0;
        $break = 0;
        $sshh = 0;
        $refrigerio = 0;
        $feedback = 0;
        $capacitacion = 0;
        $backoffice = 0;
        $inbound = 0;
        $outbound = 0;
        $ring_inbound = 0;
        $ring_outbound = 0;
        $hold_inbound = 0;
        $hold_outbound = 0;
        $ring_inbound_interno = 0;
        $inbound_interno = 0;
        $outbound_interno = 0;
        $ring_outbound_interno = 0;
        $hold_inbound_interno = 0;
        $hold_outbound_interno = 0;
        $ring_inbound_transfer = 0;
        $ring_outbound_transfer = 0;
        $inbound_transfer = 0;
        $hold_inbound_transfer = 0;
        $hold_outbound_transfer = 0;
        $desconectado = 0;
        $events = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28];
        $current_range_hour = "";
        //
        //Recorrer array horas
        foreach ($hours as $k => $v) {
            //Variables
            $i = $k;
            $j = $k + 1;
            $total = 0;
            $temp_diff_ini = 0;
            $temp_diff_fin = 0;
            $set = false;
            $last_data = null;
            //Params procedure
            $pfecha_ini = request("fecha_inicio");
            $pfecha_fin = request("fecha_fin");
            $puser_id = request("user");
            $prol = request("rol");
            //Validar posicion para el rango de horario
            if (isset($hours[$k + 1])) {
                $query = DB::select("CALL SP_REPORT_30('" . $pfecha_ini . "','" . $pfecha_fin . "','" . $hours[$k] . "','" . $hours[$k + 1] . "'," . $puser_id . ",'" . $prol . "'); ");
            } else {
                $query = DB::select("CALL SP_REPORT_30('" . $pfecha_ini . "','" . $pfecha_fin . "','" . $hours[$k] . "','" . $hours[0] . "'," . $puser_id . ",'" . $prol . "'); ");
            }
            //Si hay registros
            if (count($query)) {
                if (isset($hours[$k + 1])) {
                    $range_hour = $hours[$k] . " - " . $hours[$k + 1];
                } else {
                    $range_hour = $hours[$k] . " - " . $hours[0];
                }
                //Ultimo indice
                $index_final = count($query) - 1;
                //Recorrer registros
                foreach ($query as $kk => $vv) {
                    //Primera regla
                    //Si es el primer indice
                    if ($kk == 0) {
                        $h = (new \DateTime($query[$kk]->date_event))->format("H:i:s");
                        if ($h != $hours[$i]) {
                            $temp_diff_ini = $this->getDiffDatetime($query[$kk]->date_event, $hours[$i], true);
                        }
                    }
                    //Segunda regla
                    //Si es el ultimo indice
                    if ($kk == $index_final) {
                        $h = (new \DateTime($query[$index_final]->date_event))->format("H:i:s");
                        if ($h != $hours[$j]) {
                            $temp_diff_fin = $this->getDiffDatetime($query[$index_final]->date_event, $hours[$j], true);
                        }
                    }
                    //Recorrer array rango por hora armado
                    for ($g = 0; $g <= count($hours); $g++) {
                        //Si es diferente al rango de hora
                        if ($range_hour != $current_range_hour) {
                            //Reinicializar estados
                            $login = 0;
                            $acd = 0;
                            $break = 0;
                            $sshh = 0;
                            $refrigerio = 0;
                            $feedback = 0;
                            $capacitacion = 0;
                            $backoffice = 0;
                            $inbound = 0;
                            $outbound = 0;
                            $ring_inbound = 0;
                            $ring_outbound = 0;
                            $hold_inbound = 0;
                            $hold_outbound = 0;
                            $ring_inbound_interno = 0;
                            $inbound_interno = 0;
                            $outbound_interno = 0;
                            $ring_outbound_interno = 0;
                            $hold_inbound_interno = 0;
                            $hold_outbound_interno = 0;
                            $ring_inbound_transfer = 0;
                            $ring_outbound_transfer = 0;
                            $inbound_transfer = 0;
                            $hold_inbound_transfer = 0;
                            $hold_outbound_transfer = 0;
                            $desconectado = 0;
                            //Reinicializar total
                            $total = 0;
                        }
                        //Validar si seguimos en el rango de hora
                        if (isset($hours[$g + 1])) {
                            if ($range_hour == $hours[$g] . " - " . $hours[$g + 1]) {
                                //Set variable con rango de hora actual
                                $current_range_hour = $range_hour;
                            }
                        }
                    }
                    //Validar evento existente
                    $do = false;
                    for ($x = 0; $x <= count($events); $x++) {
                        if ($x == $vv->evento_id) {
                            $do = true;
                            break;
                        } else {
                            $do = false;
                        }
                    }
                    //Set ultimo indice para recalcular
                    if ($kk == $index_final) {
                        $vv->time_register = 0;
                        $set = true;
                        $last_data = array_merge(["data" => $vv], ["range" => $hours[$i] . " - " . $hours[$j]]);
                    } else {
                        $set = false;
                        $last_id = null;
                    }
                    //Validar y Cargar por evento
                    if ($do) {
                        switch ($vv->evento_id) {
                            case 1:
                                $acd += $vv->time_register;
                                break;
                            case 2:
                                $break += $vv->time_register;
                                break;
                            case 3:
                                $sshh += $vv->time_register;
                                break;
                            case 4:
                                $refrigerio += $vv->time_register;
                                break;
                            case 5:
                                $feedback += $vv->time_register;
                                break;
                            case 6:
                                $capacitacion += $vv->time_register;
                                break;
                            case 7:
                                $backoffice += $vv->time_register;
                                break;
                            case 8:
                                $inbound += $vv->time_register;
                                break;
                            case 9:
                                $outbound += $vv->time_register;
                                break;
                            case 11:
                                $login += $vv->time_register;
                                break;
                            case 12:
                                $ring_inbound += $vv->time_register;
                                break;
                            case 13:
                                $ring_outbound += $vv->time_register;
                                break;
                            case 15:
                                $desconectado += $vv->time_register;
                                break;
                            case 16:
                                $hold_inbound += $vv->time_register;
                                break;
                            case 17:
                                $hold_outbound += $vv->time_register;
                                break;
                            case 18:
                                $ring_inbound_interno += $vv->time_register;
                                break;
                            case 19:
                                $inbound_interno += $vv->time_register;
                                break;
                            case 20:
                                $outbound_interno += $vv->time_register;
                                break;
                            case 21:
                                $ring_outbound_interno += $vv->time_register;
                                break;
                            case 22:
                                $hold_inbound_interno += $vv->time_register;
                                break;
                            case 23:
                                $hold_outbound_interno += $vv->time_register;
                                break;
                            case 24:
                                $ring_inbound_transfer += $vv->time_register;
                                break;
                            case 25:
                                $inbound_transfer += $vv->time_register;
                                break;
                            case 26:
                                $hold_inbound_transfer += $vv->time_register;
                                break;
                            case 27:
                                $ring_outbound_transfer += $vv->time_register;
                                break;
                            case 28:
                                $hold_outbound_transfer += $vv->time_register;
                                break;
                        }
                    } else {
                        switch ($vv->evento_id) {
                            case 1:
                                $acd = $vv->time_register;
                                break;
                            case 2:
                                $break = $vv->time_register;
                                break;
                            case 3:
                                $sshh = $vv->time_register;
                                break;
                            case 4:
                                $refrigerio = $vv->time_register;
                                break;
                            case 5:
                                $feedback = $vv->time_register;
                                break;
                            case 6:
                                $capacitacion = $vv->time_register;
                                break;
                            case 7:
                                $backoffice = $vv->time_register;
                                break;
                            case 8:
                                $inbound = $vv->time_register;
                                break;
                            case 9:
                                $outbound = $vv->time_register;
                                break;
                            case 11:
                                $login = $vv->time_register;
                                break;
                            case 12:
                                $ring_inbound = $vv->time_register;
                                break;
                            case 13:
                                $ring_outbound = $vv->time_register;
                                break;
                            case 15:
                                $desconectado = $vv->time_register;
                                break;
                            case 16:
                                $hold_inbound = $vv->time_register;
                                break;
                            case 17:
                                $hold_outbound = $vv->time_register;
                                break;
                            case 18:
                                $ring_inbound_interno = $vv->time_register;
                                break;
                            case 19:
                                $inbound_interno = $vv->time_register;
                                break;
                            case 20:
                                $outbound_interno = $vv->time_register;
                                break;
                            case 21:
                                $ring_outbound_interno = $vv->time_register;
                                break;
                            case 22:
                                $hold_inbound_interno = $vv->time_register;
                                break;
                            case 23:
                                $hold_outbound_interno = $vv->time_register;
                                break;
                            case 24:
                                $ring_inbound_transfer = $vv->time_register;
                                break;
                            case 25:
                                $inbound_transfer = $vv->time_register;
                                break;
                            case 26:
                                $hold_inbound_transfer = $vv->time_register;
                                break;
                            case 27:
                                $ring_outbound_transfer = $vv->time_register;
                                break;
                            case 28:
                                $hold_outbound_transfer = $vv->time_register;
                                break;
                        }
                    }
                    //Calcular total, no sumar los ultimos registros para estabilizar los 30 min
                    if ($kk != $index_final) {
                        $total += $vv->time_register;
//                        $total += $this->getDiffDatetime($vv->date_event,$query[$kk+1]->date_event);
                    }
                }//Fin ciclo $query
                //Calcular diferencias temporales
                //Si tiene temporal inicial Ej: [00:00:00 - 00:30:00] -> 00:10:00 = 10 min
                if ($temp_diff_ini > 0) {
                    $total = $total + $temp_diff_ini;
                }
                //Si tiene temporal fin Ej: [00:00:00 - 00:30:00] -> 00:25:00 = 5 min
                if ($temp_diff_fin > 0) {
                    $total = $total + $temp_diff_fin;
                }
                //Acondicionar los resultados de diferencia por estado
                if ($set) {
                    if ($last_data != null) {
                        if ($hours[$i] . " - " . $hours[$j] == $last_data["range"]) {
                            switch ($last_data["data"]->evento_id) {
                                case 1:
                                    $acd += $temp_diff_fin;
                                    break;
                                case 2:
                                    $break += $temp_diff_fin;
                                    break;
                                case 3:
                                    $sshh += $temp_diff_fin;
                                    break;
                                case 4:
                                    $refrigerio += $temp_diff_fin;
                                    break;
                                case 5:
                                    $feedback += $temp_diff_fin;
                                    break;
                                case 6:
                                    $capacitacion += $temp_diff_fin;
                                    break;
                                case 7:
                                    $backoffice += $temp_diff_fin;
                                    break;
                                case 8:
                                    $inbound += $temp_diff_fin;
                                    break;
                                case 9:
                                    $outbound += $temp_diff_fin;
                                    break;
                                case 11:
                                    $login += $temp_diff_fin;
                                    break;
                                case 12:
                                    $ring_inbound += $temp_diff_fin;
                                    break;
                                case 13:
                                    $ring_outbound += $temp_diff_fin;
                                    break;
                                case 15:
                                    $desconectado += $temp_diff_fin;
                                    break;
                                case 16:
                                    $hold_inbound += $temp_diff_fin;
                                    break;
                                case 17:
                                    $hold_outbound += $temp_diff_fin;
                                    break;
                                case 18:
                                    $ring_inbound_interno += $temp_diff_fin;
                                    break;
                                case 19:
                                    $inbound_interno += $temp_diff_fin;
                                    break;
                                case 20:
                                    $outbound_interno += $temp_diff_fin;
                                    break;
                                case 21:
                                    $ring_outbound_interno += $temp_diff_fin;
                                    break;
                                case 22:
                                    $hold_inbound_interno += $temp_diff_fin;
                                    break;
                                case 23:
                                    $hold_outbound_interno += $temp_diff_fin;
                                    break;
                                case 24:
                                    $ring_inbound_transfer += $temp_diff_fin;
                                    break;
                                case 25:
                                    $inbound_transfer += $temp_diff_fin;
                                    break;
                                case 26:
                                    $hold_inbound_transfer += $temp_diff_fin;
                                    break;
                                case 27:
                                    $ring_outbound_transfer += $temp_diff_fin;
                                    break;
                                case 28:
                                    $hold_outbound_transfer += $temp_diff_fin;
                                    break;
                            }
                        }
                    }
                }
            } else {
                $login = 0;
                $acd = 0;
                $break = 0;
                $sshh = 0;
                $refrigerio = 0;
                $feedback = 0;
                $capacitacion = 0;
                $backoffice = 0;
                $inbound = 0;
                $outbound = 0;
                $ring_inbound = 0;
                $ring_outbound = 0;
                $hold_inbound = 0;
                $hold_outbound = 0;
                $ring_inbound_interno = 0;
                $inbound_interno = 0;
                $outbound_interno = 0;
                $ring_outbound_interno = 0;
                $hold_inbound_interno = 0;
                $hold_outbound_interno = 0;
                $ring_inbound_transfer = 0;
                $ring_outbound_transfer = 0;
                $inbound_transfer = 0;
                $hold_inbound_transfer = 0;
                $hold_outbound_transfer = 0;
                $desconectado = 0;
                $total = 0;
                $temp_diff_ini = 0;
                $temp_diff_fin = 0;
            }
            //Set por rango de hora y estado
            if (isset($hours[$j])) {
                $data[$hours[$i] . " - " . $hours[$j]]["acd"] = $acd;
                $data[$hours[$i] . " - " . $hours[$j]]["break"] = $break;
                $data[$hours[$i] . " - " . $hours[$j]]["sshh"] = $sshh;
                $data[$hours[$i] . " - " . $hours[$j]]["refrigerio"] = $refrigerio;
                $data[$hours[$i] . " - " . $hours[$j]]["feedback"] = $feedback;
                $data[$hours[$i] . " - " . $hours[$j]]["capacitacion"] = $capacitacion;
                $data[$hours[$i] . " - " . $hours[$j]]["backoffice"] = $backoffice;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound"] = $inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["outbound"] = $outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["login"] = $login;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound"] = $ring_inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound"] = $ring_outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound"] = $hold_inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound"] = $hold_outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound_interno"] = $ring_inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound_interno"] = $inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["outbound_interno"] = $outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound_interno"] = $ring_outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound_interno"] = $hold_inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound_interno"] = $hold_outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound_transfer"] = $ring_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound_transfer"] = $inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound_transfer"] = $hold_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound_transfer"] = $ring_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound_transfer"] = $hold_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["desconectado"] = $desconectado;

                $data[$hours[$i] . " - " . $hours[$j]]["total"] = $total;
                $data[$hours[$i] . " - " . $hours[$j]]["diff_inicial"] = $temp_diff_ini;
                $data[$hours[$i] . " - " . $hours[$j]]["diff_final"] = $temp_diff_fin;
            } else {
                $data[$hours[$i] . " - " . $hours[0]]["acd"] = $acd;
                $data[$hours[$i] . " - " . $hours[0]]["break"] = $break;
                $data[$hours[$i] . " - " . $hours[0]]["sshh"] = $sshh;
                $data[$hours[$i] . " - " . $hours[0]]["refrigerio"] = $refrigerio;
                $data[$hours[$i] . " - " . $hours[0]]["feedback"] = $feedback;
                $data[$hours[$i] . " - " . $hours[0]]["capacitacion"] = $capacitacion;
                $data[$hours[$i] . " - " . $hours[0]]["backoffice"] = $backoffice;
                $data[$hours[$i] . " - " . $hours[0]]["inbound"] = $inbound;
                $data[$hours[$i] . " - " . $hours[0]]["outbound"] = $outbound;
                $data[$hours[$i] . " - " . $hours[0]]["login"] = $login;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound"] = $ring_inbound;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound"] = $ring_outbound;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound"] = $hold_inbound;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound"] = $hold_outbound;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound_interno"] = $ring_inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["inbound_interno"] = $inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["outbound_interno"] = $outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound_interno"] = $ring_outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound_interno"] = $hold_inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound_interno"] = $hold_outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound_transfer"] = $ring_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["inbound_transfer"] = $inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound_transfer"] = $hold_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound_transfer"] = $ring_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound_transfer"] = $hold_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["desconectado"] = $desconectado;

                $data[$hours[$i] . " - " . $hours[0]]["total"] = $total;
                $data[$hours[$i] . " - " . $hours[0]]["diff_inicial"] = $temp_diff_ini;
                $data[$hours[$i] . " - " . $hours[0]]["diff_final"] = $temp_diff_fin;
            }
        }

        return $this->printHtml($data);

    }

    function getReport3600()
    {
        echo "show report 3600";
    }

    function printHtml($data)
    {
        //Print html
        $html = "<table border='1' style='width: 100%;font-family: Helvetica, Arial, sans-serif;font-size: 12px'>";
        $html .= "<thead style='width: 100%;font-family: Helvetica, Arial, sans-serif;font-size: 9px'><tr>
    <th>Tiempo Rango Hora</th>
    <th style='background-color: yellow'>Diff Inicial</th>
    <th>Acd</th>
    <th>Break</th>
    <th>Sshh</th>
    <th>Refrigerio</th>
    <th>Feedback</th>
    <th>Capacitacion</th>
    <th>Backoffice</th>
    <th>Inbound</th>
    <th>Outbound</th>
    <th>Login</th>
    <th>Ring Inbound</th>
    <th>Ring Outbound</th>
    <th>Hold Inbound</th>
    <th>Hold Outbound</th>
    <th>Ring Inbound Interno</th>
    <th>Inbound Interno</th>
    <th>Outbound Interno</th>
    <th>Ring Outbound Interno</th>
    <th>Hold Inbound Interno</th>
    <th>Hold Outbound Interno</th>
    <th>Ring Inbound Transfer</th>
    <th>Inbound Transfer</th>
    <th>Hold Inbound Transfer</th>
    <th>Ring Outbound Transfer</th>
    <th>Hold Outbound Transfer</th>
    <th>Desconectado</th>
    <th style='background-color: red'>Diff Final</th>
    <th>Total</th>
    </tr></thead>";
        foreach ($data as $key => $value) {
            $html .= "<tbody><tr>";
            $html .= "<td>" . $key . "</td>";
            $html .= "<td>" . $value["diff_inicial"] . "</td>";
            $html .= "<td>" . $value["acd"] . "</td>";
            $html .= "<td>" . $value["break"] . "</td>";
            $html .= "<td>" . $value["sshh"] . "</td>";
            $html .= "<td>" . $value["refrigerio"] . "</td>";
            $html .= "<td>" . $value["feedback"] . "</td>";
            $html .= "<td>" . $value["capacitacion"] . "</td>";
            $html .= "<td>" . $value["backoffice"] . "</td>";
            $html .= "<td>" . $value["inbound"] . "</td>";
            $html .= "<td>" . $value["outbound"] . "</td>";
            $html .= "<td>" . $value["login"] . "</td>";
            $html .= "<td>" . $value["ring_inbound"] . "</td>";
            $html .= "<td>" . $value["ring_outbound"] . "</td>";
            $html .= "<td>" . $value["hold_inbound"] . "</td>";
            $html .= "<td>" . $value["hold_outbound"] . "</td>";
            $html .= "<td>" . $value["ring_inbound_interno"] . "</td>";
            $html .= "<td>" . $value["inbound_interno"] . "</td>";
            $html .= "<td>" . $value["outbound_interno"] . "</td>";
            $html .= "<td>" . $value["ring_outbound_interno"] . "</td>";
            $html .= "<td>" . $value["hold_inbound_interno"] . "</td>";
            $html .= "<td>" . $value["hold_outbound_interno"] . "</td>";
            $html .= "<td>" . $value["ring_inbound_transfer"] . "</td>";
            $html .= "<td>" . $value["inbound_transfer"] . "</td>";
            $html .= "<td>" . $value["hold_inbound_transfer"] . "</td>";
            $html .= "<td>" . $value["ring_outbound_transfer"] . "</td>";
            $html .= "<td>" . $value["hold_outbound_transfer"] . "</td>";
            $html .= "<td>" . $value["desconectado"] . "</td>";
//        $html .= "<td>" . round($value["total"] / 60, 2) . "</td>";
            $html .= "<td>" . $value["diff_final"] . "</td>";
            $html .= "<td>" . $value["total"] . "</td>";
            $html .= "</tr></tbody>";
        }
        $html .= "</table>";

        echo $html;
    }

    function getDiffDatetime($datetime_ini, $datetime_fin, $onlyTime = false)
    {
        if ($onlyTime) {
            $first = Carbon::parse(Carbon::parse($datetime_ini)->format("H:i:s"));
            $second = Carbon::parse(Carbon::parse($datetime_fin)->format("H:i:s"));
            return $first->diffInSeconds($second);// 10 min
        } else {
            $first = Carbon::parse($datetime_ini);
            $second = Carbon::parse($datetime_ini);
            return $first->diffInSeconds($second);// 10 min
        }
    }
}
