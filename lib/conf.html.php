<?php
function print_radioblock($slabel, $sname, $aoptions, $brequired = false, $checkedval = 0, $sdiv = "&nbsp;")
{
  global $html;

  echo "<tr><td><b>$slabel</b>";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  for ($i = 0; $i < count($aoptions); $i++) {
       if ($checkedval == $aoptions[$i][1])
           print_radio($aoptions[$i][0], $sname, $aoptions[$i][1], 1);
       else
           print_radio($aoptions[$i][0], $sname, $aoptions[$i][1]);
       echo $sdiv; }
  echo "</td></tr>\n";
}


/** Imprime un solo bot�n de radio con un etiqueta al lado izquierdo. Recibe como par�metros
    en el siguiente orden: La etiqueta, El valor del campo, Si est� o no chequeado*/
function print_radio($slabel, $sname, $svalue, $nchecked = 0)
{
  echo "$slabel<input type=\"radio\" name=\"$sname\" value=\"$svalue\" class=\"formulario\"";
  if ($nchecked)
      echo "checked>";
  else
      echo ">";
}

/** Imprime una fila de checkboxes con dos columnas, se le entrega los par�metros en el siguiente orden:
    Etiqueta de la fila, Nombre del campo, Arreglo de opciones, Clase CSS, Si es o no campo requerido, El
    valor que debe estar chequeado por defecto y el Caracter que divide a cada uno de los botones.*/
function print_checkblock($slabel, $sname, $aoptions, $brequired = false, $checkedval = 0, $sdiv = "&nbsp;")
{
  global $html;

  echo "<tr><td><b>$slabel</b>";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  for ($i = 0; $i < count($aoptions); $i++) {
       if ($checkedval == $aoptions[$i][1])
           print_check($aoptions[$i][0], $sname, $aoptions[$i][1], 1);
       else
           print_check($aoptions[$i][0], $sname, $aoptions[$i][1]);
       echo $sdiv; }
  echo "</td></tr>\n";
}


/** Imprime un solo checkbox con un etiqueta al lado izquierdo. Recibe como par�metros
    en el siguiente orden: La etiqueta, El valor del campo, Si est� o no chequeado*/
function print_check($slabel, $sname, $svalue, $nchecked = 0)
{
  echo "$slabel<input type=\"checkbox\" name=\"$sname\" value=\"$svalue\" class=\"formulario\"";
  if ($nchecked)
      echo "checked>";
  else
      echo ">";
}

/** Imprime una fila de una tabla de HTML. Los par�mteros son:
 La etiqueta de la primera columna, el valor de texto consignado en la segunda columna
 y el estilo (CSS) que debe ser aplicado a la fila entera */
function print_dualblock($slabel, $svalue = "")
{
  echo "<tr>";
  echo "<td valign=\"top\"><b>$slabel</b></td><td valign=\"top\">$svalue</td></tr>\n";
}


/** Imprime una casilla para insertar un archivo */
function print_filebox($sname)
{
  echo "<input type=\"file\" name=\"$sname\" class=\"formulario\">";
}


/** Imprime una fila de HTML con dos columnas. Los par�metros son:
    Etiqueta de la primera columna, Nombre de la variable del archivo, Booleano que indica si el campo
    es o no obligatorio y el c�digo HTML extra que se desee insertar. */
function print_fileblock($slabel, $sname, $brequired = false, $sextrahtml = "")
{
  global $html;
  echo "<tr $sextrahtml><td width=\"100%\" class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_filebox($sname, $sextrahtml);
  echo "</td></tr>\n";
}


/** Imprime un campo <textarea> */
function print_textarea($sname, $svalue = "", $ncols = 40, $nrows = 5)
{
  $id = (isset($_REQUEST['showEditor'])) ? "ta" : "tp";
  echo "<textarea cols=$ncols rows=$nrows name=\"$sname\" class=\"formulario\" id=\"contenido\">";
  echo $svalue."</textarea>";
}


/** Imprime una fila de HTML con un campo <textarea> en El. */
function print_textareablock($slabel, $sname, $brequired = false, $svalue = "", $ncols = 30, $nrows = 5)
{
  global $html;

  echo "<tr><td valign=\"top\" class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_textarea($sname, $svalue, $ncols, $nrows);
  echo "</td></tr>\n";
}


/** Imprime un t�tulo agradable para un formulario HTML */
function print_title($stitle, $swidth = "100%")
{
  echo "<table width=\"$swidth\" align=\"center\"><tr><td align=\"right\" class=\"Tahoma12_bold\"><hr size=1 color=\"#000000\" noshade><span class=\"title\"><b>$stitle</b></span><hr size=1 color=\"#000000\" noshade></td></tr></table>\n";
}


/** Imprime el inicio de una tabla */
function print_tablestart($salign = "center", $swidth = "100%", $ncellpadding = 4, $ncellspacing = 0)
{
    echo "<table border=0 cellpadding=$ncellpadding cellspacing=$ncellspacing width=\"$swidth\" align=\"$salign\">\n";
}


/** Imprime el fin de una tabla */
function print_tableend()
{
    echo "</table>\n";
}


/** Inicio de un formulario */
function print_formstart($saction, $sname = "formulario", $method = "POST")
{
    echo "<form name=\"$sname\" enctype=\"multipart/form-data\" action=\"$saction\" method=\"$method\" onsubmit=\"return(uf_submit());\">\n";
}


/** Fin de un formulario */
function print_formeend()
{
    echo "</form>\n";
}

/** Campo oculto*/
function print_hiddenfield($sname, $svalue)
{
    echo "<input type=\"hidden\" name=\"$sname\" value=\"$svalue\">\n";
}


/** Imprime una casilla de texto */
function print_textbox($sname, $svalue = "", $sextra = "")
{
  echo "<input type=\"text\" name=\"$sname\" value=\"$svalue\" ".$sextra." class=\"formulario\">";
}


/** Imprime un bloque de HTML con una casilla de texto */
function print_inputblock($slabel, $sname, $brequired = false, $svalue = "", $sextra = "")
{
  global $html;

  echo "<tr><td class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_textbox($sname, $svalue, $sextra);
  echo "</td></tr>\n";
}


/** Casilla de password */
function print_passbox($sname, $svalue = "")
{
  echo "<input type=\"password\" name=\"$sname\" value=\"$svalue\" class=\"formulario\">";
}


/** Imprime un bloque de HTML con una casilla de password */
function print_passwordblock($slabel, $sname, $brequired = false, $svalue = "")
{
  global $html;

  echo "<tr><td class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_passbox($sname, $svalue);
  echo "</td></tr>\n";
}


/** Imprime un bloque de HTML con los botones de submit y cancelar */
function print_submitblock($ncolspan = 2)
{
  global $html;
  echo "<tr><td align=\"center\" width=\"100%\" colspan=$ncolspan><input type=submit name=\"submitbutton\" value=\"Guardar\" class=\"formulario\"></td></tr>\n";
}


/** Imprime una sola columna de texto */
function print_textblock($stext, $ncolspan = 1, $sextra="")
{
  echo "<tr><td colspan=$ncolspan width=\"100%\"";
  if ($sextra)
   echo" class=\"$sextra\"";

  echo ">$stext</td></tr>\n";
}


/** Imprime un men� <select> */
function print_selectmenu($aitems, $sname, $nselectedid = "", $sextrahtml = "",$idv=null)
{
  // Deja en blanco el primer elemento del arreglo
  array_unshift($aitems, array("", "- - -"));
  echo "<select name=\"$sname\" class=\"formulario\" id = '{$idv}' ".$sextrahtml." >";
  for ($i = 0; $i < count($aitems); $i++) {
       if (strcmp(strval($aitems[$i][0]),strval($nselectedid)) == 0)
           echo "<option value=\"".$aitems[$i][0]."\" selected>".$aitems[$i][1]."\n";
       else
           echo "<option value=\"".$aitems[$i][0]."\">".$aitems[$i][1]."\n";
  }
  echo "</select>";
}

/** Imprime un bloque de HTML con la opci�n <select> */
function print_selectblock($aitems, $sname, $slabel, $brequired = false, $nselectedid = "", $sextrahtml = "")
{
  global $html;

  echo "<tr><td class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_selectmenu($aitems, $sname, $nselectedid, $sextrahtml);
  echo "</td></tr>\n";
}


/** Imprime un bloque con tres select menu. D�a, mes y a�o. Recibe como parametros
    el nombre del listado, la etiqueta, el style sheet y un arreglo de tres posiciones con los
    valores seleccionados de a�o, mes y dia. */
function print_dateblock($slabel, $sname, $brequired = false, $selected = "1940-01-01")
{
  global $ayears, $amnth, $adays, $html;

  echo "<tr><td class=\"Tahoma10_bold\">$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td><td>";
  print_selectmenu($amnth, $sname."_mnth", substr($selected, 5, 2), $sextrahtml);
  echo "&nbsp;-&nbsp;";
  print_selectmenu($adays, $sname."_day", substr($selected, 8, 2), $sextrahtml);
  echo "&nbsp;-&nbsp;";
  print_selectmenu($ayears, $sname."_year", substr($selected, 0, 4), $sextrahtml);
  echo "</td></tr>\n";
}

/** Imprime un menU de selecciOn mUltiple */
function print_selectmenu_multiple($aitems, $sname, $size, $nselectedid = "")
{
  echo "<select multiple name=\"$sname"."[]"."\" size=\"$size\" class=\"formulario\">";
  for ($i = 0; $i < count($aitems); $i++) {
       if ($aitems[$i][0] == $nselectedid)
           echo "<option value=\"".$aitems[$i][0]."\" selected>".$aitems[$i][1];
       else
           echo "<option value=\"".$aitems[$i][0]."\">".$aitems[$i][1];
  }
  echo "</select>";
}

/** Imprime un bloque de HTML con la opciOn <select> que permite selecciones mUltiples */
function print_selectmultiple_block($aitems, $sname, $slabel, $msize,$brequired = false, $nselectedid = "")
{
  global $html;

  echo "<tr><td>$slabel";
  if ($brequired == true)
      echo "<img src=\"".$html['imgreq']."\" alt=\"Campo Obligatorio\" hspace=3>";
  echo "</td>";
  echo "<td>";
  print_selectmenu_multiple($aitems, $sname, $msize, $nselectedid);
  echo "</td></tr>\n";
}

function print_selectmenu1($aitems, $sname, $nselectedid = "", $sextrahtml = "",$idv=null)
{
  // Deja en blanco el primer elemento del arreglo
    array_unshift($aitems, array("", "- - -"));



  echo "<select name=\"$sname\" class=\"formulario\" id = '{$idv}' >";

  for ($i = 0; $i < count($aitems); $i++) {
       if (strcmp(strval($aitems[$i][0]),strval($nselectedid)) == 0)
           echo "<option value=\"".$aitems[$i][0]."\" selected>".$aitems[$i][1]."\n";
       else
           echo "<option value=\"".$aitems[$i][0]."\">".$aitems[$i][1]."\n";
  }
  echo "</select>";
}

?>
