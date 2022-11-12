<?php
function lang( string $localecode )
 {
    $con = dbaccess();
    if ( $localecode === 'es-ES' ) {
        $localestrings = [
            'storename' => mysqli_fetch_array( mysqli_query( $con, 'SELECT storename from locales where localetextid = "'.$localecode.'";') )[ 0 ],
            'currencies' => mysqli_fetch_array( mysqli_query( $con, 'SELECT currency from locales where localetextid = "'.$localecode.'";') )[ 0 ],
            'locale' => $localecode,
            'home' => 'Inicio',
            'productrelated' => 'Opciones de Producto',
            'advancedproductinfo' => 'Información de Producto Avanzada',
            'productclassesandtypes' => 'Clases & Tipos de Productos',
            'taxesanddiscounts' => 'Impuestos & Descuentos',
            'taxes' => 'Impuestos',
            'discountvouchers' => 'Vales Descuento',
            'logout' => 'Cerrar Sesión',
            'adewmplus' => ' AdEM+ UI',
            'syslogin' => 'Sistema - Inicio de Sesión',
            'username' => 'Nombre de Usuario',
            'usersnotfound' => 'No se encontraron usuarios para el inicio de sesión.',
            'contactadmin' => 'Contacte con su Administrador para añadirlo.',
            'selectusername' => 'Seleccione su nombre de usuario.',
            'password' => 'Contraseña',
            'yourpasswd' => 'Tu contraseña',
            'login' => 'Iniciar Sesión',
            'reset' => 'Restablecer',
            'dberror' => 'No se pudo conectar al servidor de Base de Datos.',
            'fillusrpass' => 'Por favor, rellene los campos de usuario y contraseña.',
            'usrpasserror' => 'Nombre de usuario y contraseña incorrectos. Por favor, inténtelo de nuevo.',
            'prodselection' => 'Selección de Producto',
            'prodnotfoundinclass' => 'No se encontraron productos asociados a esta clase.',
            'prodnotfoundinclass2' => "Por favor, añada uno o más desde la pestaña 'Opciones de Producto -> Información de Producto Avanzada', e inténtelo de nuevo.",
            'noclassesfound' => 'No se encotraron Clases de Productos.',
            'noclassesfound2' => "Por favor, añada una o más desde la pestaña 'Opciones de Producto -> Clases & Tipos de Productos'. Tras ello, añada uno o más productos desde la pestaña 'Opciones de Producto -> Información de Producto Avanzada', e inténtelo de nuevo.",
            'noprodsontable' => 'No se encontraron productos. Cuando añada uno, aparecerá aquí.',
            'noclassesontable' => 'No se encontraron clases de producto. Cuando añada una, aparecerá aquí.',
            'notypesontable' => 'No se encontraron tipos de producto. Cuando añada uno, aparecerá aquí.',
            'noprodsinvoice'=> 'No hay productos asociados a esta factura. Añada uno o más haciendo clic sobre ellos, e inténtelo de nuevo.',
            'invoicenumber' => 'Nº DE FACTURA: ',
            'employee' => 'Empleado : ',
            'prodprice' => 'Precio de Prod.',
            'quantity' => 'Cantidad',
            'checkout' => 'Precio a Pagar',
            'checkoutiva' => 'Precio a Pagar (Con IVA)',
            'totalcheckout' => 'Total a Pagar',
            'deleteinv' => 'Borrar esta Factura',
            'submitinv' => 'Guardar esta Factura',
            'intid' => 'ID Interno',
            'extid' => 'ID Externo',
            'tableprodname' => 'Nombre de Prod.',
            'tableprodfullname' => 'Nombre Completo de Prod.',
            'tableproddesc' => 'Descripción',
            'tableproddateadded' => 'Fecha de Adición',
            'tableprodclass' => 'Clase',
            'tableprodclass2' => 'Clases',
            'tableprodtype' => 'Tipo',
            'tableprodtype2' => 'Tipos',
            'tableprodimage' => 'Imagen',
            'prods2show' => ') producto(s) para mostrar.',
            'classes2show' => ') clase(s) para mostrar.',
            'types2show' => ') tipo(s) para mostrar.',
            'addproduct' => 'Añadir Nuevo Producto',
            'delproduct' => 'Eliminar Producto Existente',
            'editproduct' => 'Editar Información de Producto',
            'add1ormore' => 'Añada uno o más e inténtelo de nuevo.',
            'notypesfound' => 'No se encontraron tipos de producto.',
            'totalcheckoutstring' => 'Cantidad a Pagar',
            'product' => 'Producto',
            'class' => 'Clase',
            'type' => 'Tipo',
            'name' => 'Nombre',
            'tax' => 'Impuesto',
            'dvoucher' => 'Vale Descuento',
            'to' => ' a ',
            'user' => 'Usuario',
            'addany' => 'Añadir',
            'delany' => 'Eliminar',
            'editany' => 'Editar',
            'savebutton' => 'Guardar Cambios',
            'endconfirm' => "'.",
            'datacheck' => "Compruebe que los datos son correctos. Haga clic sobre la caja en la izquierda, y sobre '",
            'agreement' => 'Debes estar conforme antes de continuar.',
            'actionnotreversible' => ' Recuerda, esto no se puede deshacer, así que asegúrese de que el ID seleccionado es el correcto.',
            'adminoptsforadminusers' => 'Las opciones avanzadas de producto solo están disponibles para usuarios Administradores.',
            'noprods' => 'No se encontraron productos para ',
            'noprods2' => " Añada uno o más desde la pestaña 'Añadir Nuevo Producto'.",
            'noclass' => 'No se encontraron clases para ',
            'noclass2' => " Añade una o más desde la pestaña 'Añadir Clase'.",
            'notype' => 'No se encontraron tipos para ',
            'notype2' => " Añade una o más desde la pestaña 'Añadir Tipo'.",
            'classtaxperc' => 'Porcentaje de IVA de Clase',
            'noivatypes' => 'No hay tipos de IVA disponibles.',
            'classident' => 'ID Numérico de Clase',
            'admoptsclasses' => 'Las Opciones Avanzadas de Clase solo pueden ser usadas por Administradores.',
            'admoptstypes' => 'Las Opciones Avanzadas de Tipos solo pueden ser usadas por Administradores.',
            'typeper' => 'Tipo Por',
            'iva' => 'IVA',
            'inttaxes' => 'Impuestos Internos',
            'inttaxid' => 'ID de Impuesto',
            'printinvoice' => 'Imprimir Factura (PDF)',
            'taxpercent' => 'Porcentaje de Impuesto (%)',
            'notaxtytes' => 'No hay Impuestos disponibles.Al añadir uno, aparecerá aquí.',
            'taxes2show' => ') impuesto(s) para mostrar.',
            'advtaxoptsonlyforadms' => 'Las Opciones Avanzadas de Impuestos solo pueden usarlas Administradores.',
            'notaxestodel' => 'No se encontraron Impuestos para Eliminar. Añade uno o más desde la pestaña "Añadir Impuesto".',
            'vouchers' => 'Vales Descuento',
            'intvouchid' => 'ID Interno de Descuento',
            'vouchcode' => 'Código Descuento',
            'vouchdisc' => 'Porcentaje de Descuento (%)',
            'vouchdateadded' => 'Fecha de Adición',
            'vouchfinaldate' => 'Fecha Final de Uso',
            'vouchnotfound' => 'No se encontraron Vales Descuento. Al añadir uno, aparecerá aquí.',
            'percent' => '(%)',
            'vouchers2show' => ') discount voucher(s) to show',
            'voucheradvoptsonlyforadms' => 'Advanced Discount Vouchers options are only available for Administrators.',
            'novoucherstodel' => 'Could not find any discount vouchers to edit. Add one or more from the "Add Discount Voucher" tab.',
            'novoucherstoedit' => 'Could not find any discount vouchers to edit. Add one or more from the "Add Discount Voucher" tab.',
            'userinfo' => 'Advanced User Information',
            'usersuserid' => 'Internal User ID',
            'userdesc' => 'User Description',
            'userpass' => 'User Password',
            'users2show' => ') usuario(s) para mostrar.',
            'usermsg' => 'No se encontraron usuarios. ¡Qué extraño! Debes añadir uno para iniciar sesión, y debe ser "administrator".',
            'advuseroptsonlyforadms' => 'Las Opciones Avanzadas de Usuarios solo están disponibles para Administradores.',
            'msguser1' => 'No se encontraron usuarios. Eso no es normal. Recuerda que, por defecto, el usuario `administrator` se requiere para iniciar sesión, y es añadido automáticamente.',
            'msguser2' => "Si lo eliminaste por error, hay un fichero SQL ( adminrecovery.sql ), que te ayudará. Copie el contenido y ejecútelo en la sección 'SQL' desde: <a href => 'http://localhost/phpmyadmin'>localhost/phpmyadmin</a>",
            'msguser3' => 'Si hiciste esto a propósito, deberás solucionarlo por tí mismo. No damos soporte para este software si ha sido modificado de alguna manera. Gracias por utilizar este software.',
            'advsetts' => 'Configuraciones Avanzadas',
            'usernavtop' => 'Opciones de Usuarios',
            'userprofile' => 'Perfil de Usuario',
            'invoicestep2' => 'PASO 2 - CONFIRMACIÓN DE DATOS DE FACTURA & APLICACIÓN DE VALE DESCUENTO SI ES REQUERIDO',
            'invoicestep3' => 'PASO 3 - COMPROBACIÓN FINAL DE DATOS & IMPRESIÓN O GUARDADO',
            'discvtoapply' => 'VALE DESCUENTO A APLICAR (UNO POR FACTURA)',
            'nodiscvouchers' => 'No hay Vales Descuento disponibles.',
            'nodiscvouchers2' => 'Añade uno o más y vuelve a intentarlo.',
            'dontapplyvoucher' => 'No aplicar Vale Descuento.',
            'selvouchlist' => 'Seleccione un Vale Descuento de esta lista.',
            'calcvals' => 'Cálculo de Valores',
            'topayfinalprice' => 'Precio Final (a pagar)',
            'paidfinalprice' => 'Precio Final de Factura (pagado)',
            'updinvoice' => 'Guardar Factura',
            'invoicestop' => 'Búsqueda Avanzada de Facturas',
            'invoicesopts' => 'Opciones Avanzadas de Facturas',
            'invoiceid' => 'ID Interno de Factura',
            'invoicenodisc' => 'Esta factura no tiene Vales Descuento aplicados.',
            'invoicesearch' => 'Búsqueda de Facturas por ',
            'date' => 'Fecha',
            'invoices2show' => ') factura(s) para mostrar.',
            'msginvoice1' => 'No hay facturas para mostrar. Añade una o más y vuelve a intentarlo.',
            'search' => 'Realizar Búsqueda',
            'more' => 'Ver Más...',
            'moreinfo' => 'Más Información',
            'dateadded' => 'Fecha de Adición de Factura',
            'daterange' => 'Rango de Fechas',
            'mindaterange' => 'Rango de Fecha mínima',
            'maxdaterange' => 'Rango de Fecha límite',
            'loadingtime' => 'Cargando...',
            'invoicesinfo' => 'Información de Factura Resumida',
            'detailinvoiceinfo' => 'Información de Factura Detallada',
            'invoiceselect' => 'Seleccionar ID de Factura',
            'details2show' => ') detalle(s) de factura para mostrar.',
            'novoucherapplied' => 'No se aplicaron Vales Descuento.',
            'classesandtypes' => 'Información Avanzada de Clases & Tipos de Productos',
            'language' => 'Cambio de Idioma',
            'intlangid' => 'ID Interno de Idioma',
            'textlangid' => 'ID Regional de Idioma',
            'country' => 'País de Idioma',
            'tablestorename' => 'Nombre del Negocio',
            'currency' => 'Moneda de Idioma',
            'selectedlang' => 'Idioma Seleccionado (Y/N)',
            'locales2show' => ') localizacione(s) para mostrar.',
            'msglocales1' => "No hay localizaciones o lenguajes para mostrar aquí. Por defecto, se utiliza 'en-GB' como su código regional.",
            'changelang' => 'Actualizar Idioma del Gestor',
            'showinvoice' => 'Mostrar Factura Actual',
            'moreactions' => 'Más Acciones',
            'noprodsininvoice' => 'No hay productos añadidos a esta factura. Añada uno o más haciendo clic sobre él y vuelva a intentarlo.',
            'invoicesdetail' => 'Mostrar Factura',
            'serverdownorautherror' => 'No se pudo conectar al servidor de Base de Datos. Comprueba si el servidor/servicio está ejecutándose, e inténtelo de nuevo. ¿Puede que se haya especificado una contraseña incorrecta en la función "dbaccess()"?',
            'nodbaccess' => 'El servidor funciona correctamente, pero no podemos acceder a la base de datos "store", usada por este software.¿La ha creado? Ejecute el fichero "createdb.sql" en la carpeta "advanced".',
            'dbschemaerror' => 'El servidor está funcionando y podemos acceder a la base de datos, pero por alguna razón, no se puede leer su contenido. Por favor, créela de nuevo usando el fichero "createdb.sql" en la carpeta "advanced".',
            'priceempty' => '--.--',
            'notselected' => '(No seleccionado) - 0 (',
            'requiredinput' => 'Uno o más campos se enviaron vacíos, pero son requeridos.',
            'cantdeluser' => 'Este usuario no se puede borrar.',
            'invoicesearchresult' => 'Búsqueda de Facturas (resultados)',
            'invoiceuser' => 'Empleado',
            'moreinformation' => 'Más Información...',
            'selinvoice' => 'Selección de Factura',
            'details2showfrominvoices' => ') detalle(s) a mostrar de `invoices`',
            'details2showfrominvoicediscount' => ') detalle(s) a mostrar de `invoicediscount`',
            'vouchersapplied' => ') vale(s) descuento aplicado(s)',
            'invoicedetailedinfo' => 'Información Detallada de Factura'
        ];
    }
    ;
    $localestrings[ 'webmgmt' ] = $localestrings[ 'storename' ].' - '.$localestrings[ 'adewmplus' ];
    if ( isset( $_SESSION[ 'name' ] ) ) {
        $localestrings[ 'sessionname' ] = mysqli_fetch_array( mysqli_query( $con, "SELECT username from users where username = '".$_SESSION[ 'name' ]."';" ) )[ 0 ];
        $localestrings[ 'sessionrealname' ] = mysqli_fetch_array( mysqli_query( $con, "SELECT realname from users where username = '".$_SESSION[ 'name' ]."';" ) )[ 0 ];
        $localestrings[ 'userid' ] = mysqli_fetch_array( mysqli_query( $con, "SELECT userid from users where username = '".$_SESSION[ 'name' ]."';" ) )[ 0 ];
        $localestrings[ 'tableprodprice' ] = $localestrings[ 'product' ].' '.$localestrings[ 'prodprice' ];

        $localestrings[ 'classname' ] = $localestrings[ 'class' ].' '.$localestrings[ 'name' ];

        $localestrings[ 'typename' ] = $localestrings[ 'type' ].' '.$localestrings[ 'name' ];

        $localestrings[ 'taxname' ] = $localestrings[ 'tax' ].' '.$localestrings[ 'name' ];
        $localestrings[ 'edituser' ] = $localestrings[ 'editany' ].' '.$localestrings[ 'user' ];

    } else {
        $localestrings[ 'sessionname' ] = '';
        $localestrings[ 'sessionrealname' ] = '';
        $localestrings[ 'userid' ] = '';
        $localestrings[ 'tableprodprice' ] = '';
        $localestrings[ 'classname' ] = '';
        $localestrings[ 'typename' ] = '';
        $localestrings[ 'taxname' ] = '';
        $localestrings[ 'edituser' ] = '';

    }
    return $localestrings;
}
;
?>