<?php
session_start();
/*----------
DB SETTINGS
----------*/
function dbaccess()
{
    global $localestrings;
    $dbhost = '127.0.0.1';
    $dbuser = 'store';
    $dbpassword = "StoreAdmin12345$";
    $dbread = 'store';
    $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbread);
    return $con;
};

/*--------------
LOCALE SELECTOR
--------------*/
function locales(int $page)
{
    $con = dbaccess();
    if ($page === 0) {
        $localexten = '../locales/locales.' . mysqli_fetch_array(mysqli_query($con, 'SELECT localetextid FROM locales where selected =1'))[0] . '.php';
    } else {
        $localexten = './locales/locales.' . mysqli_fetch_array(mysqli_query($con, 'SELECT localetextid FROM locales where selected =1'))[0] . '.php';
    }
    include $localexten;
    $localestrings = lang(mysqli_fetch_array(mysqli_query($con, 'SELECT localetextid FROM locales where selected = 1'))[0]);
    return $localestrings;
};

/*--------------------------
BOOTSTRAP CALLER FOR OTHERS
--------------------------*/

function bootstrap()
{
    echo ('<link href="../styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../styles/bicons/bootstrap-icons.css" />
<script type="text/javascript" src="../styles/bootstrap/js/bootstrap.bundle.js" ></script>
<link rel="icon" href="../src/images/favicon/favicon.svg" />
');
}

/*-------------------------
BOOTSTRAP CALLER FOR INDEX
-------------------------*/

function bootstrapindex()
{
    echo ('<link href="./styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="./styles/bicons/bootstrap-icons.css" />
<script type="text/javascript" src="./styles/bootstrap/js/bootstrap.bundle.js" ></script>
<link rel="icon" href="./src/images/favicon/favicon.svg" />
');
}

/*----------------
RESPONSIVE DESIGN
----------------*/

function responsive()
{
    echo ('
    <style>
    @media screen{
        *{
        font-size:1.1vmax;
    }

}

@media print {
    @page {
      margin-left: 0.8in;
      margin-right: 0.8in;
      margin-top: 0;
      margin-bottom: 0;
    }
    *{
        text-align: left;
        font-size:100%vmin;
    }
 }


</style>
    ');
};

/*------------
SESSION CHECK
------------*/

function sessioncheck()
{
    if (!isset($_SESSION['name'])) {
        header('Location: ../index.php');
        exit;
    };
};

/*------------------------------------------
CHECK IF USER IS ADMIN FOR ADVANCED OPTIONS
------------------------------------------*/

function admincheck()
{
    $con = dbaccess();
    $administrator = false;
    if (!empty(mysqli_fetch_array(mysqli_query($con, "SELECT username from users where username = '" . $_SESSION['name'] . "' and username LIKE ('%admin%');"))[0])) {
        $administrator = true;
    } else {
        $administrator = false;
    }
    return $administrator;
};

/* ------------------------
LOGIN - USER SELECTION
------------------------ */

function users(array $localestrings)
{
    $con = dbaccess();
    if (mysqli_connect_errno()) {
        exit("<div class='alert alert-danger' role='alert'>" . $localestrings['dberror'] . '</div>');
    } elseif (mysqli_num_rows(mysqli_query($con, 'SELECT userid FROM users;')) <= 0) {
        echo ('<option disabled selected>' . $localestrings['usersnotfound'] . '</option>
        <option disabled>' . $localestrings['contactadmin'] . '</option>');
    } else {
        echo ('<option selected>' . $localestrings['selectusername'] . '</option>');
        $usernames = mysqli_fetch_all(mysqli_query($con, 'SELECT userid,username FROM users'));
        for (
            $x = 0;
            $x < mysqli_num_rows(mysqli_query($con, 'SELECT userid FROM store.users;'));
            $x++
        ) {
            echo ("<option value='") . $usernames[$x][1] . ("'>");
            echo $usernames[$x][1];
            echo ('</option>');
        }
    }
};
/*------------------
INDEX - FIRST LOGIN
-------------------*/

function index()
{
    $localestrings = locales(1);
    echo ('<!DOCTYPE html>
    <html class="bg-light" lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $localestrings["webmgmt"] . '
        </title>
        </head>
    <body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-light border border-bottom border-bottom-2 sticky-top">
        <h4>' . $localestrings["webmgmt"] . '
</h4>

    </nav>
    <div class="bg-light">
        <form style="width:40%;margin: 0 auto;padding:1em" class="border border-bottom" action="login/checkin.php"
            method="POST">
            <div class="alert alert-primary text-center" role="alert">
                ' . $localestrings["syslogin"] . '
</div>
            <hr>
            <div class="form-group">
                <div class="mb-3">
                    <label for="UsernameInput">' . $localestrings["username"] . '
</label>
                    <select class="form-select form-select-lg" name="username" id="UsernameInput">
                       ');
    users($localestrings);
    echo ('
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">' . $localestrings["yourpasswd"] . '
</label>
                <input type="password" name="password" class="form-control" id="examplePasswordInput1"
                    placeholder="' . $localestrings["yourpasswd"] . '" required>
            </div>
            <hr>
            <button style="margin: 0 auto;" type="submit" class="btn btn-primary">' . $localestrings["login"] . '</button>
            <button style="margin: 0 auto;" type="reset" class="btn btn-primary">' . $localestrings["reset"] . '</button>
        </form>
    </div>
</body>
</html>');
}
/*--------------------------------------------------------------
LOGIN - CHECK INPUT DATA ( PASS IF CORRECT | RETRY IF INCORRECT )
--------------------------------------------------------------*/

function checkin()
{

    $localestrings = locales(0);
    echo ("<!DOCTYPE html>
<html class='bg-light'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>" . $localestrings['storename'] . ' - ' . $localestrings['adewmplus'] . "

</title>
</head>

<body class='bg-light'>

    <nav class='navbar navbar-expand-lg navbar-light bg-light border border-bottom border-bottom-2 sticky-top'>
        <p class='h4'>" . $localestrings['storename'] . ' - ' . $localestrings['adewmplus'] . "
</h3>

    </nav>
    <div class='bg-light'>
        <form style='width:40%;margin: 0 auto;padding:1em' class='border border-bottom' action='./checkin.php'
            method='POST'>
            <div class='alert alert-primary text-center' role='alert'>
                " . $localestrings['syslogin'] . "</div>
            <hr>
            <div class='form-group'>
                <div class='mb-3'>
                    <label for='UsernameInput'>" . $localestrings['username'] . "</label>
                    <select class='form-select form-select-lg' name='username' id='UsernameInput' required>
                        ");
    users($localestrings);
    echo ("
                    </select>
                </div>
            </div>
            <div class='form-group'>
                <label for='exampleInputPassword1'>" . $localestrings['yourpasswd'] . "
</label>
                <input type='password' name='password' class='form-control' id='examplePasswordInput1'
                    placeholder='" . $localestrings['password'] . "' required>
            </div>
            <hr>
            <button style='margin: 0 auto;' type='submit' class='btn btn-primary'>" . $localestrings['login'] . "
</button>
            <button style='margin: 0 auto;' type='reset' class='btn btn-primary'>" . $localestrings['reset'] . "
</button>

");
    login($_POST['username'], $_POST['password'], $localestrings);
    echo ("
        </form>
    </div>
</body>

</html>");
};

/* ---------------------------
LOGIN - CREDENTIALS CHECK
--------------------------- */

function login($username, $password, $localestrings)
{
    $con = dbaccess();
    responsive();
    bootstrap();
    $realpassword = hash('sha512', $password);
    if (mysqli_connect_errno()) {
        echo ("<div class='alert alert-danger' role='alert'>");
        echo $localestrings['dberror'];
        exit('</div>');
    };
    if (!isset($username) or !isset($password)) {
        echo ("<div class='alert alert-danger' role='alert'>");
        echo $localestrings['fillusrpass'];
        exit('</div>');
    } else {
        if ($stmt = $con->prepare('SELECT userid,password FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $password);
                $stmt->fetch();
                if ($realpassword === $password) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['name'] = $username;
                    $_SESSION['id'] = $id;
                    header('Location:../manager/webmanager.php');
                } else {
                    echo ("<div class='alert alert-danger' role='alert'>" . $localestrings['usrpasserror'] . '</div>');
                }
            } else {
                echo ("<div class='alert alert-danger' role='alert'>" . $localestrings['usrpasserror'] . '</div>');
            }
            $stmt->close();
        };
    };
};

/*------------
NAVTOP DESIGN
------------*/

function navtop($localestrings)
{

    bootstrap();
    responsive();
    $administrator = admincheck();
    echo ('<script type="text/javascript" >
    const zeroFill = n => {
        return ("0" + n).slice(-2);
    }
    const interval = setInterval(() => {
        const now = new Date();
        const dateTime = "  " + zeroFill(now.getUTCDate()) + "/" + zeroFill((now.getMonth() + 1)) + "/" + now
            .getFullYear() + " " + zeroFill(now.getHours()) + ":" + zeroFill(now.getMinutes()) + ":" + zeroFill(now
                .getSeconds());
        document.getElementById("date-time").innerHTML = dateTime;
    }, 0500);
    </script>
    <style>
    a#menus {
        border-bottom: 2px solid transparent;
    }

    a#menus:hover {
        border-bottom: 2px solid black;
    }

    a#menubrand {
        border-bottom: 2px solid transparent;
    }
    </style>
    <nav id="navtop" class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top"
        style="z-index:10000; width: 100%;">
        <div
            style="margin:0 auto;display: flex;justify-content: space-around;flex-wrap: wrap;flex-direction: column;align-content: stretch;align-items: center; width:95%;">
            <a class="navbar-brand" id="menubrand" href="#">
                ' . $localestrings['storename'] . ' - ' . $localestrings['adewmplus'] . '
            </a>
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation" style="margin:0 auto;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mb-1" id="collapsibleNavId">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a id="menus" class="nav-link" href="../manager/webmanager.php" aria-current="page">
                            ' . $localestrings['home'] . '
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            ' . $localestrings['productrelated'] . '
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../products/products.php">
                                    ' . $localestrings['advancedproductinfo'] . '
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="../products/classtypes.php">
                                    ' . $localestrings['productclassesandtypes'] . '
                                </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            ' . $localestrings['taxesanddiscounts'] . '
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../taxes/taxes.php">
                                    ' . $localestrings['taxes'] . '
                                </a></li>
                            <li><a class="dropdown-item" href="../vouchers/vouchers.php">
                                    ' . $localestrings['discountvouchers'] . '
                                </a>
                            </li>
                        </ul>
                    </li>');

    if ($administrator === true) {
        echo ('
               <li class="nav-item dropdown">
                        <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">' . $localestrings['advsetts'] . '</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../advanced/users.php">' . $localestrings['usernavtop'] . '</a></li>
                            <li><a class="dropdown-item" href="../advanced/invoicesearch.php">' . $localestrings['invoicestop'] . '</a></li>
                            <li><a class="dropdown-item" href="../advanced/langchange.php">' . $localestrings['language'] . '</a></li>
                        </ul>
                    </li>
               ');
    } else {
    };
    echo ('</ul>
            </div>

            <div>
                <a href="../advanced/profile.php"><button type="button" class="btn btn-warning"><i
                            class="bi bi-person-fill"></i>
                       ' . $localestrings['sessionrealname'] . '
                    </button></a>
                <a href="../login/logout.php"><button type="button" class="btn btn-warning"><i class="bi bi-upload"></i>
                        ' . $localestrings['logout'] . '
                    </button></a>
                <button type="button" class="btn btn-dark"><i class="bi bi-clock"></i><span id="date-time">
                        ' . $localestrings['loadingtime'] . '
                    </span></button>
                ');
    if ($administrator === true) {
        echo ('<a href="../advanced/langchange.php"><button type="button" class="btn btn-dark"><i class="bi bi-translate"></i>' . '  ' . $localestrings['locale'] . '</button></a>');
    } else {
        echo ('<button type="button" class="btn btn-dark"><i class="bi bi-translate"></i>' . '  ' . $localestrings['locale'] . '</button>');
    }
    echo ('
            </div>
        </div>
    </nav>
');
}

/* --------------------------------------------
WEBMANAGER - SORT & SHOW PRODUCTS BY CLASS
-------------------------------------------- */

function productsbyclass()
{
    global $localestrings;
    $con = dbaccess();
    echo ("<!DOCTYPE html>
    <html style='height:-webkit-fill-available' class='bg-light' lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>" . $localestrings['storename'] . ' - ' . $localestrings['adewmplus'] . "
    </title>
</head>
<body class='bg-light'>
    <h3 class='p-3 m-0 border-bottom bg-light sticky sticky-top display-6' style='top:inherit;'>");
    echo ('' . $localestrings['prodselection'] . '');
    echo ("</h3>
    <div style='top:16%;height:30vmax;overflow-y:scroll' class='bg-light'>
        <div class='m-0 p-0 bg-light rounded-3' style='display:block;'>
            <form method='POST' action='invoiceupdater.php' class='sticky-top'>
                ");
    $sqlclasses = 'SELECT * FROM classlist';
    $resultclasses = $con->query($sqlclasses);
    if ($resultclasses->num_rows > 0) {
        while ($rowsclasses = $resultclasses->fetch_assoc()) {
            echo ("<div class='m-0 p-0 bg-light'>");
            echo ("<h4 class='border-bottom sticky sticky-top bg-light m-0 p-0'> · " . $rowsclasses['classname'] . '</h4>');
            $sqlprods = 'SELECT * FROM products where class = ' . $rowsclasses['classid'] . ';';
            $resultprods = $con->query($sqlprods);
            if ($resultprods->num_rows > 0) {

                while ($rowsprods = $resultprods->fetch_assoc()) {
                    echo ("<button type='submit' name='productsel' value=" . mysqli_fetch_array(
                        mysqli_query(
                            $con,
                            " SELECT prodid from products where prodname='" . $rowsprods['prodname'] . "';"
                        )
                    )[0] . " class='m-2 btn btn-secondary'>");
                    echo ("<image src='../products/prodimages/" .
                        $rowsprods['image'] . "' style='width:3vw;height:3vw' />");
                    echo ("<p class='m-1 p-0'>" .
                        $rowsprods['prodname'] . '</p>');
                    echo ("<p class='small m-1 p-0'>" . $rowsprods['fullname'] . '</p>');
                    echo ("<span class='badge bg-success'>" . $rowsprods['price'] .
                        $localestrings['currencies'] . '</span>');
                    echo ('<br>');
                    echo ("<span class='badge bg-warning text-dark'>Type : " . mysqli_fetch_array(
                        mysqli_query(
                            $con,
                            'SELECT typename FROM typelist WHERE typeid = ' . $rowsprods['type'] . ';'
                        )
                    )[0]
                        . '</span>');
                    echo ('</button>');
                }
            } else {
                echo ("<div class='p-2 bg-light'>");
                echo ('<p>' . $localestrings['prodnotfoundinclass'] . '</p>');
                echo ('<p>' .
                    $localestrings['prodnotfoundinclass2'] . '</p>');
                echo ('</div>');
            }
            echo ('</div>');
        }
    } else {
        echo ("<div class='p-2 border-bottom'>");
        echo ('<h4>' .
            $localestrings['noclassesfound'] . '</h4>');
        echo ('<p>' . $localestrings['noclassesfound2'] . '</p>');
        echo ('</div>');
        echo ('
        </div>');
        echo ('
    </div>
</body>
</html>');
    };
}

/*---------------------------- WEBMANAGER - INVOICE STEP 1 ---------------------------- */
function actualinvoiceid(/*HAY QUE CORREGIRLO*/)
{
    global $localestrings;
    $con = dbaccess();
    $actualinvoiceid = mysqli_fetch_array(mysqli_query($con, "SELECT max(invoiceid) from actualinvoice;"))[0];
    $invoicesmax = mysqli_fetch_array(mysqli_query($con, "SELECT max(invoiceid) from invoices"))[0];
    if (!isset($_POST['actualinvoiceid']) && $actualinvoiceid === NULL) {
        if ($actualinvoiceid === 0 && $invoicesmax === 0) {
            $actualinvoiceid = 1;
        } elseif ($actualinvoiceid > $invoicesmax) {
            $actualinvoiceid = $actualinvoiceid + 1;
        } elseif ($actualinvoiceid < $invoicesmax) {
            $actualinvoiceid = $invoicesmax + 1;
        };
    } else {
        return $actualinvoiceid;
    };
}

function invoice()
{
    global $localestrings;
    $con = dbaccess();
    $timestamp = mysqli_fetch_array(
        mysqli_query(
            $con,
            'SELECT current_timestamp();'
        )
    )[0];
    $actualinvoiceid = actualinvoiceid();
    echo ('<style>.checkout>*{
        font-size:0.9vmax;
    };</style>
    <div id="checkout" class="border-top bottom sticky sticky-bottom"
    style="width:100%;position:fixed;left:0%;background-color:#cfe2ff;">
    <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;"><button
            class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample">
            <p class="m-0 p-0 display-6">'
        . $localestrings['invoicesdetail'] . '</p>
        </button></div>
    <div class="collapse" id="collapseExample">
    <div class="table-responsive">
        <h3 class="m-2 p-0" >' . $localestrings['invoicenumber'] . $actualinvoiceid . ' - ' .
        $timestamp . '</h3>
        <h5 class="m-2 p-1" >' . $localestrings['employee'] .
        mysqli_fetch_array(
            mysqli_Query(
                $con,
                "SELECT realname from users where username = '" .
                    $localestrings['sessionname'] . "';"
            )
        )[0] . '</h5>
            <input type="hidden" value="' . $actualinvoiceid . '" name="actualinvoiceid"></input>
            
                <table class="table table-primary">
                    <thead>
                        <tr">
                            <th scope="col"><b >' . $localestrings['tableprodname'] . '</b></th>
                            <th scope="col"><b >' . $localestrings['prodprice'] . '</b></th>
                            <th scope="col"><b >' . $localestrings['quantity'] . '</b></th>
                            <th scope="col"><b >' . $localestrings['checkout'] . '</b></th>
                            <th scope="col"><b >' . $localestrings['checkoutiva'] . '</b></th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr>');
    if (
        mysqli_num_rows(
            mysqli_query(
                $con,
                'SELECT * FROM actualinvoice where invoiceid = "' . $actualinvoiceid . '";'
            )
        ) === 0
    ) {
        echo ("<th scope='row' colspan=5");
        echo ('<p >' . $localestrings['noprodsininvoice'] . '</p>'
        );
        echo ('</th>');
    } else {
        $sqlinvoice = 'select * from actualinvoice where invoiceid = "' . $actualinvoiceid . '";';
        $resultinvoice = ($con->query($sqlinvoice));
        $rowinvoice = [];
        if ($resultinvoice->num_rows > 0) {
            $rowinvoice = $resultinvoice->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowinvoice)) {
        foreach ($rowinvoice as $rowsinvoice) {
            echo ('<tr>');
            echo ("<th scope='col' style='font-size:0.95vmax;'>");
            echo ('<p>' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT prodname from products
                                    where prodid = ' . $rowsinvoice['prodid'] . ';'
                )
            )[0] . '</p>');
            echo ('</th>');
            echo ("<th scope='col'>");
            echo ('<p>' . $rowsinvoice['price']) . $localestrings['currencies'] . ('</p>');
            echo ('</th>');
            echo ("<th scope='col'>");
            echo ('<p>' . $rowsinvoice['quantity'] . "<button name='delprod'
                                        class='btn btn-secondary m-1 p-1.5' value=" . $rowsinvoice['prodid'] . '>-</button></p>');
            echo ('</th>');
            echo (" <th scope='col'>");
            echo ('<p>' . $rowsinvoice['checkout'] . $localestrings['currencies'] . '
                                        </p>');
            echo ('</th>');
            echo ("<th scope='col'>");
            echo ('<p>' . $rowsinvoice['checkoutplusiva'] . $localestrings['currencies'] . ' -
                                    (' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT ivaperc FROM ivas where ivaid =
                                    (SELECT ivaperclass from classlist where classid =(SELECT class from products where
                                    prodid ="' . $rowsinvoice['prodid'] . '"))'
                )
            )[0] . '% IVA)</p>');
            echo ('</th>');
        }
    }
    echo ('</tr>');
    echo ('</tbody>');
    echo ('<tfoot>');
    echo ('<tr>');
    echo ("<th scope='col' colspan=3><b>" . $localestrings['totalcheckoutstring'] . "</b><div style='border-bottom:2px dotted black;width:100%;display:inline-flex;'></div></th>");
    if (!isset($actualinvoiceid)) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } elseif (mysqli_num_rows(mysqli_query($con, 'SELECT checkout FROM actualinvoice where invoiceid = "' . $actualinvoiceid . '";')) === 0) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } else {
        $totalcheckout = mysqli_fetch_array(mysqli_query($con, 'SELECT SUM(CHECKOUT) from actualinvoice where invoiceid = "' . $actualinvoiceid . '";'))[0];
        $totalcheckoutplusiva = mysqli_fetch_array(mysqli_query($con, 'SELECT SUM(CHECKOUTPLUSIVA) from actualinvoice where invoiceid = "' . $actualinvoiceid . '";'))[0];
        echo ("<th scope='col'><b>" . $totalcheckout . $localestrings['currencies'] . "</b></th>");
        echo ("<th scope='col'><b>" . $totalcheckoutplusiva . $localestrings['currencies'] . "<b></th>");
    };
    echo ('<tr>');
    echo ('<td scope="col"><button class="btn btn-primary" type="submit" name="delinv">' . $localestrings['deleteinv'] . '</button></td></form>');
    echo ('<td scope="col" colspan="3"></td>
                            <td scope="col">');

    echo ('<form action="invoicecomplete.php" method="POST">
                                    <button type="submit" class="btn btn-primary" name="subinv">' .
        $localestrings['submitinv'] .
        '</button>');

    echo ('                                <input type="hidden" value="' . $actualinvoiceid . '"
                                        name="actualinvoiceid"></input>
                                    <input type="hidden" value="' . $localestrings['userid'] . '" name="userid"></input>
                                    <input type="hidden" value="' . $timestamp . '" name="timestamp"></input>
                                      </form>
                    </tfoot>
                </table>
            </div>
    </div>
</div>
</div>
</div>');
};
/* -----------------------------
INVOICE - INVOICE STEP 2
----------------------------- */

function firstinvoicecheck($invoiceid, $timestamp)
{
    global $localestrings;
    $con = dbaccess();
    echo ("<!DOCTYPE html>
<html style='height:-webkit-fill-available' class='bg-light' lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . $localestrings['webmgmt'] . "</title>
</head>

<body class='bg-light'>");
    echo ('<h3 class="m-2 p-1 border-bottom"><b><a href="invoicecomplete.php"><i class="bi bi-arrow-left-circle"></i></a>' .
        ' ' . $localestrings['invoicestep2'] . '</b></h3>
<form method="POST" action="updateinvoiceiv.php" class="sticky-top">
    <div id="checkout" class="bg-light bottom sticky-bottom mx-3">
        <h3 class="m-3 p-0">' . $localestrings['invoicenumber'] . $invoiceid . ' - ' .
        $timestamp . '</h3>
        <h5 class="m-2 p-1">
            ' . $localestrings['employee'] . $localestrings['sessionrealname'] . '
            <input type="hidden" value="' . $invoiceid . '" name="actualinvoiceid"></input>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col"><b>' . $localestrings['product'] . ' ' . $localestrings['name'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['prodprice'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['quantity'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['checkout'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['checkoutiva'] . '</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>');
    if (
        mysqli_num_rows(
            mysqli_query(
                $con,
                'SELECT * FROM actualinvoice where invoiceid = "' . $invoiceid . '";'
            )
        ) === 0
    ) {
        echo ("<th scope='row' colspan=6>");
        echo $localestrings['noprodsininvoice'];
        echo ("</th>");
    } else {
        $sqlinvoice = 'select * from actualinvoice where invoiceid
                            = "' . $invoiceid . '";';
        $resultinvoice = ($con->query($sqlinvoice));
        $rowinvoice = [];
        if ($resultinvoice->num_rows > 0) {
            $rowinvoice = $resultinvoice->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowinvoice)) {
        foreach ($rowinvoice as $rowsinvoice) {
            echo ('
                        <tr>');
            echo ("<td scope='col'>");
            echo ('' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT prodname from products
                                where prodid = "' . $rowsinvoice['prodid'] . '";'
                )
            )[0] . '');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('' . $rowsinvoice['price']) . $localestrings['currencies'] . ('');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('' . $rowsinvoice['quantity'] . '');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('<h6>' . $rowsinvoice['checkout'] . $localestrings['currencies'] . '</h6>
                                ');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('' . $rowsinvoice['checkoutplusiva'] . $localestrings['currencies'] . ' -
                                (' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT ivaperc FROM ivas where ivaid =
                                (SELECT ivaperclass from classlist where classid =(SELECT class from products where
                                prodid ="' . $rowsinvoice['prodid'] . '"))'
                )
            )[0] . '% IVA)');
            echo ('</td>');
        }
    };
    echo ('</tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" colspan="3"><b>' . $localestrings['totalcheckoutstring'] . '</b>
                                <div style="border-bottom:2px dotted black;width:100%;display:inline-flex;"></div>
                            </th>');
    if (!isset($invoiceid)) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } elseif (
        mysqli_num_rows(
            mysqli_query(
                $con,
                'SELECT checkout FROM actualinvoice
                            where invoiceid = "' . $invoiceid . '";'
            )
        ) === 0
    ) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } else {
        echo ("<th scope='col'>");
        $totalcheckout = mysqli_fetch_array(
            mysqli_query(
                $con,
                'SELECT SUM(CHECKOUT) from
                                actualinvoice where invoiceid = "' . $invoiceid . '";'
            )
        )[0];
        echo ('<b>' . $totalcheckout . $localestrings['currencies'] . '<b>');
        echo ('</th>');
        echo ("<th scope='col'>");
        $totalcheckoutplusiva = mysqli_fetch_array(
            mysqli_query(
                $con,
                'SELECT
                                SUM(CHECKOUTPLUSIVA) from actualinvoice where invoiceid
                                = "' . $invoiceid . '";'
            )
        )[0];
        echo ('<b>' . $totalcheckoutplusiva . $localestrings['currencies'] . '<b>');
        echo ('</th>');
    };
    echo ('
</tr>
</form>
</tfoot>
</table>
</div>
</div>
</div>
<h5 class="m-2 p-1 border-bottom"><b></b>
    <div class="col-9 p-2 m-2 " style="display: inline-flex;">
        <div class="form-floating col-3">
            <select class="form-select" name="vouchervalue" id="vouchervalue"
                aria-label="' . $localestrings['selvouchlist'] . '">');
    $sqlvouchers = 'select * from discountvouchers where finaldate >= CURRENT_DATE;';
    $resultvouchers = ($con->query($sqlvouchers));
    $rowvouchers = [];
    if ($resultvouchers->num_rows > 0) {
        $rowvouchers = $resultvouchers->fetch_all(MYSQLI_ASSOC);
    };
    if (!empty($rowvouchers)) {
        foreach ($rowvouchers as $rowsvouchers) {

            echo ('<option value=' . $rowsvouchers['vouchid'] . '>' . $rowsvouchers['voucher'] . ' (' .
                $rowsvouchers['vouchpercent'] . '%)</option>');
        }
    } else {
        echo (" <option disabled value='0'>" .
            $localestrings['nodiscvouchers'] . "</option>
                <option disabled>" . $localestrings['nodiscvouchers2'] . '</option>');
    }
    echo ("<option selected value='0'>" . $localestrings['dontapplyvoucher'] . '</option>');
    echo ('
            </select>
            <label for="vouchervalue">' . $localestrings['selvouchlist'] . '</label>
        </div>
    </div>
    <div class="col-9 p-2 m-2" style="display: inline-flex;">
        <div class="form-floating col-3">
            <input type="hidden" name="actualinvoiceid" value="' . $invoiceid . '"></input>
            <input type="hidden" name="userid" value="' . $localestrings['userid'] . '"></input>
            <input type="hidden" name="timestamp" value="' . $timestamp . '"></input>
            <button type="submit" class="btn btn-warning">' . $localestrings['calcvals'] . '</button>
        </div>
    </div>
    </form>');
};
/*----------------------- 
INVOICE - INVOICE STEP 3
-----------------------*/
function
printinginvoice(
    $timestamp,
    $invoiceid,
    $voucher
) {
    global $localestrings;
    $con = dbaccess();
    if (!isset($_POST['actualinvoiceid']) || $_POST['actualinvoiceid'] === '') {
        header('Location: webmanager.php');
        exit();
    }
    if (
        empty($_POST['vouchervalue']) || $_POST['vouchervalue'] === 0
    ) {
        $voucher = 0;
    } else {
        if (
            $_POST['vouchervalue'] === 0
        ) {
            $voucher = 0;
        }
        $voucher = $_POST['vouchervalue'];
    }

    echo ("<!DOCTYPE html>
<html style='height:-webkit-fill-available' class='bg-light' lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' href='../src/images/favicon/favicon.svg' />
    <title>
        " . $localestrings['webmgmt'] . "
    </title>
</head>
<body class='bg-light'>");
    echo ('<h3 class="m-2 p-1 border-bottom" id="stepthree"><b><a href="webmanager.php">
                <i class="bi bi-arrow-left-circle"></i></a>' . ' ' . $localestrings['invoicestep3'] . '</b></h3>');
    echo ('<div id="checkout" class="bg-light bottom sticky-bottom mx-3">
        <h3 class="m-3 p-0">' . $localestrings['invoicenumber'] . $invoiceid . ' - ' . $timestamp . '</h3>
        <h5 class="m-2 p-1">
            ' . $localestrings['employee'] . $localestrings['sessionrealname'] . '
            <input type="hidden" value="' . $invoiceid . '" name="actualinvoiceid"></input>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col"><b>' . $localestrings['product'] . ' ' . $localestrings['name'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['prodprice'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['quantity'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['checkout'] . '</b></th>
                            <th scope="col"><b>' . $localestrings['checkoutiva'] . '</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>');
    if (
        mysqli_num_rows(
            mysqli_query(
                $con,
                'SELECT * FROM actualinvoice where invoiceid = "' . $invoiceid . '";'
            )
        ) === 0
    ) {
        echo ("<th scope='row' colspan=6>" . $localestrings['noprodsininvoice'] . "</th>"
        );
    } else {
        $sqlinvoice = 'select * from actualinvoice where invoiceid = "' . $invoiceid . '";';
        $resultinvoice = ($con->query($sqlinvoice));
        $rowinvoice = [];
        if ($resultinvoice->num_rows > 0) {
            $rowinvoice = $resultinvoice->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowinvoice)) {
        foreach ($rowinvoice as $rowsinvoice) {

            echo ('
                        <tr>');
            echo ("<td scope='col'>");
            echo ('<p>' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT prodname from products
                                    where prodid = "' . $rowsinvoice['prodid'] . '";'
                )
            )[0] . '</p>');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('<p>' . $rowsinvoice['price']) . $localestrings['currencies'] . ('</p>');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('<p>' . $rowsinvoice['quantity'] . '');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('<p>' . $rowsinvoice['checkout'] . $localestrings['currencies'] . '</p>');
            echo ('</td>');
            echo ("<td scope='col'>");
            echo ('<p>' . $rowsinvoice['checkoutplusiva'] . $localestrings['currencies'] . ' -
                                    (' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT ivaperc FROM ivas where ivaid =
                                    (SELECT ivaperclass from classlist where classid =(SELECT class from products where
                                    prodid= "' . $rowsinvoice['prodid'] . '"))'
                )
            )[0] . '% IVA)</p>');
            echo ('</td>');
        }
    }

    echo ('</tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" colspan="3"><b>' . $localestrings['totalcheckoutstring'] . '</b>
                                <div style="border-bottom:2px dotted black;width:100%;display:inline-flex;"></div>
                            </th>');
    if (!isset($invoiceid)) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } elseif (mysqli_num_rows(mysqli_query($con, 'SELECT checkout FROM actualinvoice where invoiceid = "' . $invoiceid . '";')) === 0) {
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
        echo ("<th scope='col'><b>" . $localestrings['priceempty'] . $localestrings['currencies'] . '</b></th>');
    } else {
        $totalcheckout = mysqli_fetch_array(mysqli_query($con, 'SELECT SUM(CHECKOUT) from actualinvoice where invoiceid = "' . $invoiceid . '";'))[0];
        $totalcheckoutplusiva = mysqli_fetch_array(mysqli_query($con, 'SELECT SUM(CHECKOUTPLUSIVA) from actualinvoice where invoiceid = "' . $invoiceid . '";'))[0];
        echo ("<th scope='col'><b>" . $totalcheckout . $localestrings['currencies'] . "</b></th>");
        echo ("<th scope='col'><b>" . $totalcheckoutplusiva . $localestrings['currencies'] . "<b></th>");
    };
    echo ("
                        </tr>
                        <tr>
                            <th scope='col' colspan='4'>");
    echo ($localestrings['vouchers'] . '</th>
                            <th>');
    if ($voucher === 0) {
        echo '<p>' . $localestrings['notselected'] . $localestrings['currencies'] . ')' . '</p>';
        $vouchertotal = round($totalcheckoutplusiva * (0 / 100), 2);
    } else {
        $voucherpercentdiscount = mysqli_fetch_array(
            mysqli_query(
                $con,
                'SELECT
                                vouchpercent FROM discountvouchers where vouchid = "' . $voucher . '";'
            )
        )[0];
        $vouchercodefromdb = mysqli_fetch_array(
            mysqli_query(
                $con,
                'SELECT voucher FROM
                                discountvouchers where vouchid = "' . $voucher . '";'
            )
        )[0];
        $vouchertotal = round(
            $totalcheckoutplusiva * ($voucherpercentdiscount / 100),
            2
        );
        echo $vouchercodefromdb . (' (') . $voucherpercentdiscount . ('%) - ') .
            $vouchertotal . $localestrings['currencies'];
    }
    echo ('</th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="4"><b>' . $localestrings['topayfinalprice'] . '</b>
                                <div style="border-bottom:2px dotted black;width:100%;display:inline-flex;"></div>
                            </th>
                            <th scope="col"><b>');

    $totalcheckoutplusiva = mysqli_fetch_array(
        mysqli_query(
            $con,
            'SELECT
                                    SUM(CHECKOUTPLUSIVA) from actualinvoice where invoiceid = ' . $invoiceid . ';'
        )
    )[0];
    $totalcheckoutplusivalessvoucher = $totalcheckoutplusiva - $vouchertotal;
    echo $totalcheckoutplusivalessvoucher . $localestrings['currencies'];
    echo ('</b></th>
                        </tr>');
    echo (" <tr>
                            <td scope='col' colspan='5'>
                                <form action='uploadinvoice.php' method='POST'>
                                    <button id='updinv' class='btn btn-primary' type='submit' name='subinv'>" .
        $localestrings['updinvoice'] . "</button>
                                    <a type='button' class='btn btn-primary' id='crearpdf'>Print Invoice (PDF)</a>
                                    <input type='hidden' value='" . $invoiceid . "' name='actualinvoiceid'></input>
                                    <input type='hidden' value='" . $timestamp . "' name='timestamp'></input>
                                    <input type='hidden' value='" . $voucher . "' name='vouchervalue'></input>
                                    <input type='hidden' value='" . $totalcheckoutplusivalessvoucher . "'
                                        name='finalprice'></input>
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
    </div>
    </div>
    <script type='text/javascript'>
    document.addEventListener('DOMContentLoaded', () => {
        let boton = document.getElementById('crearpdf');
        let boton2 = document.getElementById('updinv');
        let navtop = document.getElementById('navtop');
        let text3 = document.getElementById('stepthree');
        let container = document.getElementById('checkout');

        boton.addEventListener('click', event => {
            event.preventDefault();
            navtop.style.display = 'none';
            boton.style.display = 'none';
            boton2.style.display = 'none';
            text3.style.display = 'none';
            window.print();
            navtop.style.display = 'block';
            boton.style.display = 'initial';
            boton2.style.display = 'initial';
            text3.style.display = 'block';
        }, false);
    }, false);
    </script>
</body>

</html>");
};

/*-------------------------------------
ADVANCED PRODUCT INFORMATION & ACTIONS
---------------------------------------*/

function advprodsinfo()
{
    global $localestrings;
    $administrator = admincheck();
    $con = dbaccess();
    echo ('
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../src/images/favicon/favicon.svg" />
    <title>' . $localestrings['webmgmt'] . '</title>
</head>

<body>
    <div class="p-0 mb-4 bg-light rounded-3">
        <div class="container-fluid py-4 margin-0 padding-0" style="">
            <h3 class="display-6"><a href="../manager/webmanager.php"><i style="font-size:100%"
                        class="bi bi-arrow-left-circle"></i></a>' . $localestrings['advancedproductinfo'] . '
            </h3>
            <div class="table-responsive bg-light" style="overflow-y:scroll;top:16%;height:25vmax;">
                <table class="table table-striped table-hover table-borderless table-primary align-middle">
                    <thead>
                        <tr style="position: sticky; top:0;">
                            <th>' . $localestrings['intid'] . '
                            </th>
                            <th>' . $localestrings['extid'] . '
                            </th>
                            <th>' . $localestrings['tableprodname'] . '
                            </th>
                            <th>' . $localestrings['tableprodfullname'] . '
                            </th>
                            <th>' . $localestrings['tableproddesc'] . '
                            </th>
                            <th>' . $localestrings['tableproddateadded'] . '
                            </th>
                            <th>' . 'Price (' . $localestrings['currencies'] . ')' . '
                            </th>
                            <th>' . $localestrings['tableprodclass'] . '
                            </th>
                            <th>' . $localestrings['tableprodtype'] . '
                            </th>
                            <th>' . $localestrings['tableprodimage'] . '
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        ');
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM products')) === 0) {
        echo ('<tr>');
        echo ('<td colspan=10>' . $localestrings['noprodsontable'] . '</td>
                        </tr>');
    } else {
        $sql = 'select * from products';
        $result = ($con->query($sql));
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($row)) {
        foreach ($row as $rows) {

            echo ('<tr>
                            <td>' . $rows['prodid'] . '
                            </td>
                            <td>' . $rows['realid'] . '
                            </td>
                            <td>' . $rows['prodname'] . '
                            </td>
                            <td>' . $rows['fullname'] . '
                            </td>
                            <td>' . $rows['proddesc'] . '
                            </td>
                            <td>' . $rows['dateadded'] . '
                            </td>
                            <td>' . $rows['price'] . $localestrings['currencies'] . '
                            </td>
                            <td>
                                ' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT classname from
                                classlist,products WHERE ' . $rows['class'] . ' = classlist.classid;'
                )
            )[0] . '
                            </td>
                            <td>' . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT typename,type from
                                typelist,products WHERE ' . $rows['type'] . ' = typelist.typeid;'
                )
            )[0] . '
                            </td>
                            <td><img src=./prodimages/' . $rows['image'] . ' width=45px height=45px/>
        </td>
                        </tr>');
        };
    }
    echo (' </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <caption class="sticky-bottom">' . '(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from products'))[0] . $localestrings['prods2show'] . '
            </caption>

        </div>
    </div>
    ');
    if ($administrator === true) {
        echo ('<div id="moreactions" class="bg-white border-top bottom sticky sticky-bottom"
        style="width:100%;position:fixed;left:0%;">
        <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;"><button
                class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                <h3 class="display-6">' . $localestrings['moreactions']
            . '</h3>
            </button></div>
        <div class="collapse" id="collapseExample">
            <nav class="nav nav-pills" id="nav-tab" role="tablist">
                <a class="nav-link ml-1 mt-1" id="nav-addproduct-tab" data-bs-toggle="tab" href="#nav-addproduct" role="tab"
                    aria-controls="nav-addproduct" aria-selected="true">'
            . $localestrings['addproduct']
            . '</a>
                <a class="nav-link ml-1 mt-1" id="nav-deleteproduct-tab" data-bs-toggle="tab" href="#nav-deleteproduct" role="tab"
                    aria-controls="nav-deleteproduct" aria-selected="false">'
            . $localestrings['delproduct']
            . '</a>
                <a class="nav-link ml-1 mt-1" id="nav-editproduct-tab" data-bs-toggle="tab" href="#nav-editproduct" role="tab"
                    aria-controls="nav-editproduct" aria-selected="false">'
            . $localestrings['editproduct'] . '</a>
            </nav>');
    } else {
        echo ('<p class="m-2 p-2">' . $localestrings['adminoptsforadminusers'] . '</p>');
    };
    echo ("
            <div class='tab-content' id='nav-tabContent'>
                <div class='bg-white tab-pane fade show' id='nav-addproduct' role='tabpanel'
                    aria-labelledby='nav-addproduct-tab'>
                    ");
    addprodpage();
    echo ("</div>
                <div class='tab-content' id='nav-tabContent'>
                    <div class='bg-white tab-pane fade show' id='nav-deleteproduct' role='tabpanel'
                        aria-labelledby='nav-deleteproduct-tab'>
                        ");
    delprodpage();
    echo (" </div>
                    <div class='tab-content' id='nav-tabContent'>
                        <div class='bg-white tab-pane fade show' id='nav-editproduct' role='tabpanel'
                            aria-labelledby='nav-editproduct-tab'>
                            ");
    editprodpage();
    echo ("</div>
                    </div>
                </div>
            </div></body>
            </html>");
};

/*-----------------------------------------------
PRODUCT ACTIONS PAGE (ADD | DELETE | EDIT) FORMS
-----------------------------------------------*/
function addprodpage()
{
    $con = dbaccess();
    global $localestrings;
    echo ('<form action="productactions.php" enctype="multipart/form-data" method="POST">
    <div style="display:inline-flex; padding-left:2em; width:100%">
        </button>
        <div class="col-3">
            <label for="extprodid" class="form-label">' . $localestrings['extid'] . '</label>
            <input type="number" class="form-control" name="extprodid" id="extprodid" aria-describedby="helpId"
                placeholder="' . $localestrings['extid'] . '" required>
        </div>
        <div class="col-3">
            <label for="prodname" class="form-label">' . $localestrings['tableprodname'] . '</label>
            <input type="text" class="form-control" name="prodname" id="prodname" aria-describedby="helpId"
                placeholder="' . $localestrings['tableprodname'] . '" required>
        </div>
        <div class="col-3">
            <label for="fullname" class="form-label">' . $localestrings['tableprodfullname'] . '</label>
            <input type="text" class="form-control" name="fullname" id="fullname" aria-describedby="helpId"
                placeholder="' . $localestrings['tableprodfullname'] . '" required>
        </div>
        <div class="col-3">
            <label for="description" class="form-label">' . $localestrings['tableproddesc'] . '</label>
            <textarea class="form-control" name="description" id="description" aria-describedby="helpId"
                placeholder="' . $localestrings['tableproddesc'] . '" required></textarea>
        </div>
    </div>
    <div style="display:inline-flex;padding-left:2em">
        <div class="col-3">
            <label for="dateadded" class="form-label">' . $localestrings['tableproddateadded'] . '</label>
            <input type="date" class="form-control" name="dateadded" id="dateadded" aria-describedby="helpId"
                placeholder="' . $localestrings['tableproddateadded'] . '">
        </div>
        <div class="col-3">
            <label for="price" class="form-label">' . $localestrings['prodprice'] . '</label>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="helpId" step="any"
                placeholder="' . $localestrings['prodprice'] . '" required>
        </div>
        <div class="col-3">
            <label for="prodclass" class="form-label">' . $localestrings['tableprodclass'] . '</label>
            <select class="form-select form-select-lg" name="prodclass" id="UsernameInput" required>');
    if (mysqli_num_rows(mysqli_query($con, "SELECT classid FROM classlist;")) <= 0) {
        echo ("<option disabled selected>");
        echo $localestrings['noclassesfound'];
        echo ("</option>");
        echo ("<option disabled>");
        echo $localestrings['add1ormore'];
        echo ("</option>");
    } else {
        $classes = mysqli_fetch_all(mysqli_query($con, 'SELECT classid,classname FROM classlist'));
        for ($x = 0; $x < mysqli_num_rows(mysqli_query($con, "SELECT classid FROM store.classlist;")); $x++) {
            echo ("<option value='") . $classes[$x][0] . ("'>");
            echo $classes[$x][1];
            echo ("</option>");
        }
    }
    echo ('</select>
        </div>
        <div class="col-3">
            <label for="prodtype" class="form-label">' . $localestrings['tableprodtype'] . '</label>
            <select class="form-select form-select-lg" name="prodtype" id="UsernameInput" required>');
    if (mysqli_num_rows(mysqli_query($con, "SELECT typeid FROM typelist;")) <= 0) {
        echo ("<option disabled selected>");
        echo $localestrings['notypesfound'];
        echo ("</option>");
        echo ("<option disabled>");
        echo $localestrings['add1ormore'];
        echo ("</option>");
    } else {
        $types = mysqli_fetch_all(mysqli_query($con, 'SELECT typeid,typename FROM typelist'));
        for ($x = 0; $x < mysqli_num_rows(mysqli_query($con, "SELECT typeid FROM store.typelist;")); $x++) {
            echo ("<option value='") . $types[$x][0] . ("'>");
            echo $types[$x][1];
            echo ("</option>");
        }
    };
    echo (' </select>
        </div>
        </div>
        <div style="display:inline-flex;padding-left:2em">
        <div class="col-13">
            <label for="prodimage[]" class="form-label">' . $localestrings['tableprodimage'] . '</label>
            <input type="file" class="form-control" name="prodimage[]" id="prodimage[]" aria-describedby="helpId"
                placeholder="' . $localestrings['tableprodimage'] . '" value="default.png" default="default.png">
                </div>
    </div>
    <div style="display:block;padding-left:2em;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">
                ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['product'] . $localestrings['endconfirm'] . '
            </label>
            <div class="invalid-feedback">
                ' . $localestrings['agreement'] . '
            </div>
        </div>
    
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['product'] . '</button>
    </div>
    </div>
</form>
');
}
function delprodpage()
{
    global $localestrings;
    $con = dbaccess();
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM products')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['noprods'] . $localestrings['delany'] . '.' . $localestrings['noprods2'] . '</p></div>');
    } else {
        echo ('
        <form action="productactions.php" method="POST">
        <div class="col-10"  style="display:inline-flex; padding-left:2em;></button>
                <span class="navbar-toggler-icon"></span>
               <div class="col-3">
          <label for="delprodbyid" class="form-label">' . $localestrings['intid'] . '</label>
          <input type="number" class="form-control" name="delprodbyid" id="delprodbyid" aria-describedby="helpId" placeholder="' . $localestrings['intid'] . '" required>
        </div>
        <div class="col-3">
          <label for="delprodbyname" class="form-label">' . $localestrings['tableprodname'] . '</label>
          <input type="text" class="form-control" name="delprodbyname" id="delprodbyname" aria-describedby="helpId" placeholder="' . $localestrings['tableprodname'] . '" required>
        </div>
    </div>
      <div class="col-10 pt-2"  style="display:inline-flex; padding-left:2em;>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="delete" required>
          <label class="form-check-label" for="delete">
            ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['product'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '
          </label>
            <div class="invalid-feedback">
            ' . $localestrings['agreement'] . '
            </div>
        </div>

        <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['product'] . '</button>
      </div>
      </div>
      </div>
    </form>
    ');
    };
}
function editprodpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM products')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em;'><p>" . $localestrings['noprods'] . $localestrings['editany'] . '.' . $localestrings['noprods2'] . "</p></div></div>");
    } else {
        echo ('
        <form action="productactions.php" method="POST" enctype="multipart/form-data">
        <div class="col-10" style="display:inline-flex; padding-left:2em;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="selprodbyid" class="form-label">' . $localestrings['intid'] . $localestrings['to'] . $localestrings['editany'] . '</label>
          <input type="number" class="form-control" name="selprodbyid" id="selprodbyid" aria-describedby="helpId" placeholder="' . $localestrings['intid'] . $localestrings['to'] . $localestrings['editany'] . '" required>
        </div>
        <div class="col-3">
          <label for="newrealid" class="form-label">' . $localestrings['extid'] . '</label>
          <input type="number" class="form-control" name="newrealid" id="newrealid" aria-describedby="helpId" placeholder="' . $localestrings['extid'] . '">
        </div>
        <div class="col-3">
          <label for="newprodname" class="form-label">' . $localestrings['tableprodname'] . '</label>
          <input type="text" class="form-control" name="newprodname" id="newprodname" aria-describedby="helpId" placeholder="' . $localestrings['tableprodname'] . '">
        </div>
        <div class="col-3">
          <label for="newfullname" class="form-label">' . $localestrings['tableprodfullname'] . '</label>
          <input type="text" class="form-control" name="newfullname" id="newfullname" aria-describedby="helpId" placeholder="' . $localestrings['tableprodfullname'] . '">
        </div>
        <div class="col-3">
          <label for="newproddesc" class="form-label">' . $localestrings['tableproddesc'] . '</label>
          <textarea class="form-control" name="newproddesc" id="newproddesc" aria-describedby="helpId" placeholder="' . $localestrings['tableproddesc'] . '"></textarea>
        </div>
        </div>
        <div class="col-9" style="display:inline-flex; padding-left:2em;">
        <div class="col-1.5">
        <label for="newdate" class="form-label">' . $localestrings['tableproddateadded'] . '</label>
        <input type="date" class="form-control" name="newdate" id="newdate" aria-describedby="helpId" placeholder="' . $localestrings['tableproddateadded'] . '">
      </div>
        <div class="col-3">
          <label for="newprice" class="form-label">' . $localestrings['tableprodprice'] . '</label>
          <input type="number" class="form-control" name="newprice" id="newprice" aria-describedby="helpId" step="any" placeholder="' . $localestrings['tableprodprice'] . '">
        </div>
        <div class="col-3">
        <label for="prodclass" class="form-label">' . $localestrings['tableprodclass'] . '</label>
        <select class="form-select form-select-lg" name="prodclass" id="prodclass" required>');
        if (mysqli_num_rows(mysqli_query($con, 'SELECT classid FROM classlist;')) <= 0) {
            echo ('<option disabled selected>');
            echo $localestrings['noclassesfound'];
            echo ('</option>');
            echo ('<option disabled>');
            echo $localestrings['add1ormore'];
            echo ('</option>');
        } else {
            $classes = mysqli_fetch_all(mysqli_query($con, 'SELECT classid,classname FROM classlist'));
            for (
                $x = 0;
                $x < mysqli_num_rows(mysqli_query($con, 'SELECT classid FROM store.classlist;'));
                $x++
            ) {
                echo ("<option value='") . $classes[$x][0] . ("'>");
                echo $classes[$x][1];
                echo ('</option>');
            }
        };
        echo ("</select>
        </div>
        <div class='col-3'>
        <label for='prodtype' class='form-label'>" . $localestrings['tableprodtype'] . "</label>
        <select class='form-select form-select-lg' name='prodtype' id='UsernameInput' required>");
        if (mysqli_num_rows(mysqli_query($con, 'SELECT typeid FROM typelist;')) <= 0) {
            echo ('<option disabled selected>');
            echo $localestrings['notypesfound'];
            echo ('</option>');
            echo ('<option disabled>');
            echo $localestrings['add1ormore'];
            echo ('</option>');
        } else {
            $types = mysqli_fetch_all(mysqli_query($con, 'SELECT typeid,typename FROM typelist'));
            for (
                $x = 0;
                $x < mysqli_num_rows(mysqli_query($con, 'SELECT typeid FROM store.typelist;'));
                $x++
            ) {
                echo ("<option value='") . $types[$x][0] . ("'>");
                echo $types[$x][1];
                echo ('</option>');
            }
        };
        echo ("</select>
            </div>

            <div class='col-3'>
            <label for='newprodimage[]' class='form-label'>" . $localestrings['tableprodimage'] . "</label>
            <input type='file' class='form-control' name='newprodimage[]' id='newprodimage[]' aria-describedby='helpId' placeholder='" . $localestrings['tableprodimage'] . "'>
          </div>
            </div>

          <div class='col-10' style='display:inline-flex; padding-left:2em;'>
            <div class='form-check'>
              <input class='form-check-input' type='checkbox' name='edit' id='invalidCheck' required>
              <label class='form-check-label' for='invalidCheck'>
                " . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . "
              </label>
              <div class='invalid-feedback'>
                " . $localestrings['agreement'] . "
            </div>
            </div>
            </div>
          <div class='col-12' style='display:inline-flex; padding-left:2em; padding-top:1em;'>
          <button style='width:20%' class='btn btn-primary' type='submit'>" . $localestrings['savebutton'] . "</button>
          </div>
          </div>
        </form>                </div>
        </div>");
    };
}

/*----------------------
PRODUCT ACTIONS (QUERY)
----------------------*/
function addprod($extprodid, $prodname, $fullname, $description, $dateadded, $price, $class, $type, $image)
{
    $con = dbaccess();
    if ($extprodid === null || $prodname === null || $fullname === null || $description === null || $dateadded === null || $price === null || $class === null || $type === null) {
        header('Location:products.php');
        exit();
    } else {
        if ($dateadded === '') {
            $dateadded = date('Y-m-d');
        } else {
            $dateaddedprod = $dateadded;
        }
        if (!isset($image)) {
            $prodimage = "default.png";
        } else {
            $prodimage = $image;
        }
        $action = "INSERT INTO products VALUES (''," . $extprodid . ",'" . $prodname . "','" . $fullname . "','" . $description . "','" . $dateaddedprod . "'," . $price . "," . $class . "," . $type . ",'" . $prodimage . "')";
        mysqli_real_query($con, $action);
    }
    header('Location:products.php');
};

function delprod($delprodbyid, $delprodbyname)
{
    if ($delprodbyid === null || $delprodbyname === null) {
        header('Location:products.php');
        exit();
    } else {
        $con = dbaccess();
        $action = "DELETE FROM products WHERE prodid = " . $delprodbyid . " AND prodname = '" . $delprodbyname . "';";
        mysqli_real_query($con, $action);
    };
};
function editprod($selprodbyid, $newrealid, $newprodname, $newfullname, $newproddesc, $newdateadded, $newprice, $newclass, $newtype, $newprodimage)
{
    $con = dbaccess();
    $action = "UPDATE products set realid ='" . $newrealid . "', prodname ='" . $newprodname . "', fullname ='" . $newfullname . "', proddesc = '" . $newproddesc . "',dateadded ='" . $newdateadded . "', price ='" . $newprice . "', class = " . $newclass . ", type = " . $newtype . ", image = '" . $newprodimage . "' WHERE prodid = '" . $selprodbyid . "';";
    echo $action;
    mysqli_real_query($con, $action);
};

/*---------------------
CLASSES & TYPES (PAGE)
---------------------*/
function classesandtypes()
{
    global $localestrings;
    $administrator = admincheck();
    $con = dbaccess();
    global $localestrings;
    echo ("
<!DOCTYPE html>
<html>
<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>" . $localestrings['webmgmt'] . "</title>
</head>

<body><div class='p-0 mb-4 bg-light rounded-3'>
                <h3 class='p-2'><a href='../manager/webmanager.php'><i class='bi bi-arrow-left-circle'></i></a>" .
        $localestrings['classesandtypes']
        . "</h3>
                <div class='container-fluid py-4 margin-0 padding-0' style='display: inline-flex;'>
                    <div class='table-responsive bg-light' style='top:16%;height:47vh;overflow-y:scroll;width: 100%;
width: -moz-available;          /* WebKit-based browsers will ignore this. */
width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
width: fill-available;'>
                        <h3>" . $localestrings['tableprodclass2'] . "</h3>
                        <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                            <thead>
                                <tr style='position: sticky; top:0;'>
                                    <th>" . $localestrings['class'] . ' ' . $localestrings['intid'] . "</th>
                                    <th>" . $localestrings['classname'] . "</th>
                                    <th>" . $localestrings['iva'] . ' ' . $localestrings['type'] . "</th>
                                </tr>
                            </thead>
                            <tbody class='table-group-divider'>");
    if (
        mysqli_num_rows(
            mysqli_query(
                $con,
                'SELECT * FROM classlist'
            )
        ) === 0
    ) {
        echo ('<tr>');
        echo ('<td colspan=10>' . $localestrings['noclassesontable'] . '</td>
                                </tr>');
    } else {
        $sqlclass = 'select * from classlist';
        $resultclass = ($con->query($sqlclass));
        $rowclass = [];
        if ($resultclass->num_rows > 0) {
            $rowclass = $resultclass->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowclass)) {
        foreach ($rowclass as $rowsclass) {
            echo ("
                                <tr>

                                    <td>" . $rowsclass['classid'] . "
                                    </td>
                                    <td>" . $rowsclass['classname'] . "
                                    </td>
                                    <td>" . mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT ivatype from ivas where ivaid =
                                        ' . $rowsclass['ivaperclass'] . ';'
                )
            )[0] . (' (') . (mysqli_fetch_array(
                mysqli_query(
                    $con,
                    'SELECT ivaperc from ivas where ivaid = ' . $rowsclass['ivaperclass'] . ';'
                )
            )[0]) . (' %)') . "
                                    </td>
                                </tr>");
        };
    }
    echo (" </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>

                    <div class='table-responsive bg-light' style='overflow-y:scroll;width: 100%;
width: -moz-available;          /* WebKit-based browsers will ignore this. */
width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
width: fill-available;'>
                        <h3>" . $localestrings['tableprodtype2'] . "
                        </h3>
                        <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                            <thead>
                                <tr style='position: sticky; top:0;'>
                                    <th>" . $localestrings['intid'] . "
                                    </th>
                                    <th>" . $localestrings['type'] . ' ' . $localestrings['name'] . "
                                    </th>
                                </tr>
                            </thead>
                            <tbody class='table-group-divider'>");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM typelist')) === 0) {
        echo ('<tr>');
        echo ('<td colspan=10>' . $localestrings['notypesontable'] . '</td>
                                </tr>');
    } else {
        $sqltypes = 'select * from typelist';
        $resulttypes = ($con->query($sqltypes));
        $rowtypes = [];
        if ($resulttypes->num_rows > 0) {
            $rowtypes = $resulttypes->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowtypes)) {
        foreach ($rowtypes as $rowstypes) {
            echo ("
                                <tr>

                                    <td>" . $rowstypes['typeid'] . "</td>
                                    <td>" . $rowstypes['typename'] . "</td>
                                </tr>");
        };
    }
    echo (" </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class='p-0 bg-light rounded-3' style='display: inline-flex;width:100%;'>
                    <div class='container-fluid  margin-0 padding-0' style='display: inline-flex;'>
                        <div class='table-responsive bg-light p-2' style='width: 100%;
width: -moz-available;          /* WebKit-based browsers will ignore this. */
width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
width: fill-available;'>
                            <caption class='sticky-bottom p-2'>");
    echo ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from classlist'))[0] . $localestrings['classes2show']);
    echo (" </caption>
                        </div>
                    </div>
                    <div class='table-responsive bg-light p-2' style='width: 100%;
width: -moz-available;          /* WebKit-based browsers will ignore this. */
width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
width: fill-available;'>
                        <caption class='sticky-bottom'>
                            ");
    echo ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from typelist'))[0] .
        $localestrings['types2show']);
    echo ("
                        </caption>

                    </div>
                </div>
            </div>");
    if ($administrator === true) {
        echo ("<div id='moreactions' class='bg-white border-top bottom sticky sticky-bottom'
                style='width:100%;position:fixed;left:0%;'>
                <div class='sticky sticky-bottom' style='bottom:0%;z-index:12500;top:0%;left:0%;display:block;'><button
                        class='btn btn-primary' type='button' data-bs-toggle='collapse'
                        data-bs-target='#collapseExample' aria-expanded='false' aria-controls='collapseExample'>
                        <p class='m-0 p-0 display-6'>" . $localestrings['moreactions'] . "</p>
                    </button></div>
                <div class='collapse' id='collapseExample'>
                    <nav class='nav nav-pills' id='nav-tab' role='tablist'>
                        <a class='nav-link ml-1 mt-1' id='nav-addclass-tab' data-bs-toggle='tab' href='#nav-addclass' role='tab'
                            aria-controls='nav-addclass' aria-selected='true'>" . $localestrings['addany'] . ' ' . $localestrings['class'] . "</a>
                        <a class='nav-link ml-1 mt-1' id='nav-deleteproduct-tab' data-bs-toggle='tab' href='#nav-deleteclass'
                            role='tab' aria-controls='nav-deleteclass' aria-selected='false'>" .
            $localestrings['delany'] . ' ' . $localestrings['class'] . "</a>
                        <a class='nav-link ml-1 mt-1' id='nav-editproduct-tab' data-bs-toggle='tab' href='#nav-editclass'
                            role='tab' aria-controls='nav-editclass' aria-selected='false'>" .
            $localestrings['editany'] . ' ' . $localestrings['class'] . "</a>
                        <a class='nav-link ml-1 mt-1' id='nav-addtype-tab' data-bs-toggle='tab' href='#nav-addtype' role='tab'
                            aria-controls='nav-addtype' aria-selected='true'>" . $localestrings['addany'] . ' ' . $localestrings['type'] . "</a>
                        <a class='nav-link ml-1 mt-1' id='nav-deletetype-tab' data-bs-toggle='tab' href='#nav-deletetype'
                            role='tab' aria-controls='nav-deletetype' aria-selected='false'>" .
            $localestrings['delany'] . ' ' . $localestrings['type'] . "</a>
                        <a class='nav-link ml-1 mt-1' id='nav-edittype-tab' data-bs-toggle='tab' href='#nav-edittype' role='tab'
                            aria-controls='nav-edittype' aria-selected='false'>" . $localestrings['editany'] . ' ' . $localestrings['type'] . "</a>
                    </nav>");
    } else {
        echo ("<p class='p-2 m-2'>" . $localestrings['admoptsclasses'] . '</p>');
        echo ("<p class='p-2 m-2'>" . $localestrings['admoptstypes'] . '</p>');
    };
    echo ("<div class='tab-content' id='nav-tabContent'>
                        <div class='bg-white tab-pane fade show' id='nav-addclass' role='tabpanel'
                            aria-labelledby='nav-addclass-tab'> ");
    addclasspage();
    echo ("</div>
                        <div class='tab-content' id='nav-tabContent'>
                            <div class='bg-white tab-pane fade show' id='nav-deleteclass' role='tabpanel'
                                aria-labelledby='nav-deleteclass-tab'>");
    delclasspage();
    echo ("</div>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='bg-white tab-pane fade show' id='nav-editclass' role='tabpanel'
                                    aria-labelledby='nav-editclass-tab'>
                                    ");
    editclasspage();
    echo ("</div>
                                <div class='tab-content' id='nav-tabContent'>
                                    <div class='bg-white tab-pane fade show' id='nav-addtype' role='tabpanel'
                                        aria-labelledby='nav-addtype-tab'>
                                        ");
    addtypepage();
    echo ("</div>
                                    <div class='tab-content' id='nav-tabContent'>
                                        <div class='bg-white tab-pane fade show' id='nav-deletetype' role='tabpanel'
                                            aria-labelledby='nav-deletetype-tab'>
                                            ");
    deltypepage();
    echo ("
                                        </div>
                                        <div class='tab-content' id='nav-tabContent'>
                                            <div class='bg-white tab-pane fade show' id='nav-edittype' role='tabpanel'
                                                aria-labelledby='nav-edittype-tab'>
                                                ");
    edittypepage();
    echo ("
                                            </div>
                                        </div>
                                    </div>
                                    </body>
                                    </html>");
};

/*-------------
ADD CLASS PAGE
-------------*/
function addclasspage()
{
    global $localestrings;
    $con = dbaccess();
    echo (' <form action="classactions.php" method="POST">
    <div class="col-10" style="display: inline-flex;">
        <div class="col-4" style="padding-left:2em; padding-top:1em; ">

            <label for="classname" class="form-label">' . $localestrings['classname'] . '</label>
            <input type="text" class="form-control" name="classname" id="classname" aria-describedby="helpId"
                placeholder="' . $localestrings['classname'] . '" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">

            <label for="classivaperc" class="form-label">' . $localestrings['classtaxperc'] . '</label>
            <select class="form-control" name="classivaperc">
               ');
    $sqlivas = "select * from ivas;";
    $resultivas = ($con->query($sqlivas));
    $rowivas = [];
    if ($resultivas->num_rows > 0) {
        $rowivas = $resultivas->fetch_all(MYSQLI_ASSOC);
    };
    if (!empty($rowivas))
        foreach ($rowivas as $rowsivas) {
            echo ("<option value=" . $rowsivas['ivaid'] . ">" . $rowsivas['ivatype'] . " (" . $rowsivas['ivaperc'] . "%)</option>");
        }
    else {
        echo ("
<option disabled>" . $localestrings['noivatypes'] . "</option>
<option disabled>" . $localestrings['add1ormore'] . "</option>");
    }
    echo ('            </select>
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['class'] . $localestrings['endconfirm'] . '
            </label>
            <div class="invalid-feedback">
                ' . $localestrings['agreement'] . ' </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%;" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['class'] . '</button>
    </div>
</form>');
};

/*----------------
DELETE CLASS PAGE
----------------*/
function delclasspage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM classlist')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo '<p>' . $localestrings['noclass'] . $localestrings['delany'] . '. ' . $localestrings['noclass2'] . '</p></div>';
    } else {
        echo ('<form action="classactions.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="delclassbyid" class="form-label">' . $localestrings['classident'] . '</label>
          <input type="number" class="form-control" name="delclassbyid" id="delclassbyid" aria-describedby="helpId" placeholder="' . $localestrings['classident'] . '" required>
          </div>
          <div class="col-3">
          <label for="delclassbyname" class="form-label">' . $localestrings['classname'] . '</label>
          <input type="text" class="form-control" name="delclassbyname" id="delclassbyname" aria-describedby="helpId" placeholder="' . $localestrings['classname'] . '" required>
        </div>
        </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
         ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['class'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['class'] . '</button>
      </div>
      </div>
    </form>');
    };
};

/*--------------
EDIT CLASS PAGE
--------------*/
function editclasspage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM classlist')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo '<p>' . $localestrings['noclass'] . $localestrings['editany'] . '. ' . $localestrings['noclass2'] . '</p></div>';
    } else {
        echo ('
        <form action="classactions.php" method="POST">
        <div class="p-2 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="selclassbyid" class="form-label">' . $localestrings['intid'] . '</label>
          <input type="number" class="form-control" name="selclassbyid" id="selclassbyid" aria-describedby="helpId" placeholder="' . $localestrings['intid'] . '" required>
        </div>
            <div class="col-3">
          <label for="newclassname" class="form-label">' . $localestrings['classname'] . '</label>
          <input type="text" class="form-control" name="newclassname" id="newclassname" aria-describedby="helpId" placeholder="' . $localestrings['classname'] . '">
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
        <label for="classivaperc" class="form-label">' . $localestrings['classtaxperc'] . '</label>
    <select class="form-control" name="classivaperc">');
        $sqlivas = 'select * from ivas;';
        $resultivas = ($con->query($sqlivas));
        $rowivas = [];
        if ($resultivas->num_rows > 0) {
            $rowivas = $resultivas->fetch_all(MYSQLI_ASSOC);
        };
        if (!empty($rowivas))
            foreach ($rowivas as $rowsivas) {

                echo ('<option value=' . $rowsivas['ivaid'] . '>' . $rowsivas['ivatype'] . ' (' . $rowsivas['ivaperc'] . '%)</option>');
            }
        else {
            echo ("
    <option disabled>" . $localestrings['noivatypes'] . "</option>
    <option disabled>" . $localestrings['add1ormore'] . '</option>');
        }
        echo ('</select>
        </div>
        </div>
        <div class="col-10" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
          ' . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . '      
          </label>
          <div class="invalid-feedback">
          ' . $localestrings['agreement'] . '      </div>
        </div>
        </div>
    
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
      <button style="width:20%" class="btn btn-primary" type="submit">Save Changes</button>
      </div>
      </div>
        </form>');
    };
};

/*------------
ADD TYPE PAGE
------------*/
function addtypepage()
{
    global $localestrings;
    $con = dbaccess();
    echo ('<form action="typeactions.php" method="POST">
    <div class="col-10">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">

            <label for="typename" class="form-label">' . $localestrings['typename'] . '</label>
            <input type="text" class="form-control" name="typename" id="typename" aria-describedby="helpId"
                placeholder="' . $localestrings['typename'] . '" required />
        </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
                <label class="form-check-label" for="invalidCheck">
                    ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['type'] . $localestrings['endconfirm'] . '
                </label>
                <div class="invalid-feedback">
                    ' . $localestrings['agreement'] . '
                </div>
            </div>
        </div>
        <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
            <button style="width:20%;" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['type'] . '</button>
        </div>
    </div>
</form>');
};

/*---------------
DELETE TYPE PAGE
---------------*/
function deltypepage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM typelist')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo '<p>' . $localestrings['notype'] . $localestrings['delany'] . '. ' . $localestrings['notype2'] . '</p></div>';
    } else {
        echo ('<form action="typeactions.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="deltypebyid" class="form-label">' . $localestrings['intid'] . '</label>
          <input type="number" class="form-control" name="deltypebyid" id="deltypebyid" aria-describedby="helpId" placeholder="' . $localestrings['intid'] . '" required>
          </div>
          <div class="col-3">
          <label for="deltypebyname" class="form-label">' . $localestrings['typename'] . '</label>
          <input type="text" class="form-control" name="deltypebyname" id="deltypebyname" aria-describedby="helpId" placeholder="' . $localestrings['typename'] . '" required>
        </div>
        </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
    ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['type'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '</label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['type'] . '</button></div>
    </form>');
    };
};

/*-------------
EDIT TYPE PAGE
-------------*/
function edittypepage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM typelist')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['notype'] . $localestrings['editany'] . '.' . $localestrings['notype2'] . '</p></div>');
    } else {
        echo ('
        <form action="typeactions.php" method="POST">
        <div class="p-2 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="seltypebyid" class="form-label">' . $localestrings['intid'] . '</label>
          <input type="number" class="form-control" name="seltypebyid" id="seltypebyid" aria-describedby="helpId" placeholder="' . $localestrings['intid'] . '" required>
        </div>
            <div class="col-3">
          <label for="newtypename" class="form-label">' . $localestrings['typename'] . '</label>
          <input type="text" class="form-control" name="newtypename" id="newtypename" aria-describedby="helpId" placeholder="' . $localestrings['typename'] . '">
        </div>
        </div>
        <div class="col-10" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            ' . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>      </div>
    
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
      <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['savebutton'] . '</button>
      </div>
      </div>
        </form>');
    };
};

/*-------------------------------------
INVOICE CREATION / UPDATING / DELETION
-------------------------------------*/
function invoicedataconf($invoiceid)
{
    $con = dbaccess();
    if (isset($_POST['productsel'])) {
        $price = mysqli_fetch_array(mysqli_query($con, 'SELECT price from products where prodid = "' . $_POST['productsel'] . '";'))[0];
        if (mysqli_num_rows(mysqli_query($con, "SELECT prodid from actualinvoice where prodid = '" . $_POST['productsel'] . "' AND invoiceid = '" . $invoiceid . "';")) === 0) {
            $quantity = 1;
            $checkout = $price * $quantity;
            $checkoutplusiva = $checkout + ($checkout * (mysqli_fetch_array(mysqli_query($con, 'SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid ="' . $_POST['productsel'] . '"))')))[0] / 100);
            mysqli_real_query($con, "INSERT INTO actualinvoice VALUES ('" . $invoiceid . "','" . $_POST['productsel'] . "','" . $price . "','" . $quantity . "','" . $checkout . "','" . $checkoutplusiva . "');");
        } else {
            $oldquantity = mysqli_fetch_array(mysqli_query($con, "SELECT quantity from actualinvoice where invoiceid = '" . $invoiceid . "' AND prodid = '" . $_POST['productsel'] . "';"))[0];
            $quantity = $oldquantity + 1;
            $checkout = $price * $quantity;
            $checkoutplusiva = $checkout + ($checkout * (mysqli_fetch_array(mysqli_query($con, 'SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid ="' . $_POST['productsel'] . '"))')))[0] / 100);
            mysqli_real_query($con, "UPDATE actualinvoice set quantity = '" . $quantity . "', checkout = '" . $checkout . "', checkoutplusiva = '" . $checkoutplusiva . "' WHERE prodid = '" . $_POST['productsel'] . "' and invoiceid = '" . $invoiceid . "';");
        }
    } elseif (isset($_POST['delinv'])) {
        mysqli_real_query($con, 'DELETE FROM actualinvoice where invoiceid = "' . $_POST['actualinvoiceid'] . '";');
    } elseif (isset($_POST['delprod'])) {
        $oldquantity = mysqli_fetch_array(mysqli_query($con, 'SELECT quantity from actualinvoice where prodid = "' . $_POST['delprod'] . '" and invoiceid = "' . $invoiceid . '";'))[0];
        $quantity = $oldquantity - 1;
        $price = mysqli_fetch_array(mysqli_query($con, 'SELECT price from products where prodid = "' . $_POST['delprod'] . '";'))[0];
        $checkout = $price * $quantity;
        $checkoutplusiva = $checkout + ($checkout * (mysqli_fetch_array(mysqli_query($con, 'SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid ="' . $_POST['delprod'] . '"));')))[0] / 100);
        mysqli_real_query($con, 'UPDATE actualinvoice set quantity = "' . $quantity . '", checkout = "' . $checkout . '", checkoutplusiva = "' . $checkoutplusiva . '" WHERE prodid = "' . $_POST['delprod'] . '"and invoiceid = "' . $invoiceid . '";');
        if (mysqli_fetch_array(mysqli_query($con, 'SELECT quantity from actualinvoice where prodid = "' . $_POST['delprod'] . '" and invoiceid = "' . $invoiceid . '";'))[0] <= 0) {
            mysqli_real_query($con, 'DELETE FROM actualinvoice where prodid = "' . $_POST['delprod'] . '" and invoiceid = "' . $invoiceid . '";');
        }
    };
    header('Location:../manager/webmanager.php');
};

/*----------------------------
STEP 4 - UPLOAD INVOICE TO DB
----------------------------*/
function uploadinvoice($invoiceid, $timestamp, $discountid, $userid)
{
    $con = dbaccess();
    if ($discountid === '0') {
        $discountid = NULL;
    } else {
        $discountid = $_POST['vouchervalue'];
    }
    mysqli_real_query($con, 'INSERT INTO invoicediscount VALUES ("' . $invoiceid . '","' . $discountid . '");');
    mysqli_real_query($con, 'INSERT INTO invoices VALUES ("' . $invoiceid . '","' . $timestamp . '","' . $userid . '");');
    mysqli_real_query($con, 'INSERT INTO detailinvoice SELECT * FROM actualinvoice WHERE invoiceid = "' . $invoiceid . '";');
    mysqli_real_query($con, 'DELETE from actualinvoice where invoiceid = "' . $invoiceid . '";');
    header('Location:webmanager.php');
};

/*------------------------------
CLASS ACTIONS (ADD|DELETE|EDIT)
------------------------------*/
function addclass($classname, $classivaperc)
{
    $con = dbaccess();
    $action = "INSERT INTO classlist VALUES ('','" . $classname . "','" . $classivaperc . "');";
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
};

function delclass($id, $name)
{
    $con = dbaccess();
    if (isset($id) && isset($name)) {
        $action = 'DELETE FROM classlist WHERE classid = ' . $id . " AND classname = '" . $name . "';";
    };
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
}

function editclass($selclassbyid, $classname, $classivaperc)
{
    $con = dbaccess();
    if (!isset($classname)) {
        $newclassname = mysqli_fetch_array(mysqli_query($con, 'SELECT classname from classlist WHERE classid = ' . $selclassbyid . ';'))[0];
    } else {
        $newclassname = $classname;
    }
    if (!isset($classivaperc)) {
        $newclassivaperc = mysqli_fetch_array(mysqli_query($con, 'SELECT ivaperclass from classlist WHERE classid = ' . $selclassbyid . ';'))[0];
    } else {
        $newclassivaperc = $classivaperc;
    };
    $action = "UPDATE classlist set classname ='" . $newclassname . "', ivaperclass ='" . $newclassivaperc . "' WHERE classid = " . $selclassbyid . ';';
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
};

/*------------------------------
    TYPES ACTIONS (ADD|DELETE|EDIT)
    ------------------------------*/
function addtype($typename)
{
    $con = dbaccess();
    if (isset($typename)) {
        $action = "INSERT INTO typelist VALUES ('','" . $typename . "')";
    } else {
        header('Location:classtypes.php');
    };
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
}
function deltype($deltypebyid, $deltypebyname)
{
    $con = dbaccess();
    if (isset($deltypebyid) && isset($deltypebyname)) {
        $action = 'DELETE FROM typelist WHERE typeid = ' . $deltypebyid . " AND typename = '" . $deltypebyname . "';";
    } else {
        header('Location:classtypes.php');
    }
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
};

function edittype($seltypebyid, $newtypename)
{
    $con = dbaccess();
    if (isset($seltypebyid)) {
        if ($_POST['newtypename'] === '') {
            $typename = mysqli_fetch_array(mysqli_query($con, 'SELECT typename from typelist WHERE typeid = ' . $_POST['seltypebyid'] . ';'))[0];
        } else {
            $typename = $newtypename;
        };
        $action = "UPDATE typelist set typename ='" . $typename . "' WHERE typeid = " . $seltypebyid . ';';
    } else {
        header('Location:classtypes.php');
    }
    mysqli_real_query($con, $action);
    header('Location:classtypes.php');
}

/*---------
TAXES PAGE
---------*/
function taxes()
{
    $con = dbaccess();
    global $localestrings;
    $administrator = admincheck();
    echo ("<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>" . $localestrings['webmgmt'] . "
    </title>
</head>

<body>
    <div class='container-fluid py-4 margin-0 padding-0 bg-light'>
        <div class='table-responsive bg-light' style='top:16%;height:57vh;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;'>
            <h3><a href='../manager/webmanager.php'><i class='bi bi-arrow-left-circle'></i></a>" . $localestrings['inttaxes'] . "
</h3>
            <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                <thead>
                    <tr style='position: sticky; top:0;'>
                        <th>" . $localestrings['inttaxid'] . "
</th>
                        <th>" . $localestrings['tax'] . ' ' . $localestrings['name'] . "
</th>
                        <th>" . $localestrings['taxpercent'] . "
</th>
                    </tr>
                </thead>
                <tbody class='table-group-divider'>");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM ivas')) === 0) {
        echo ('<tr>');
        echo ('<td colspan=3>' . $localestrings['notaxtytes'] . '</td></tr>');
    } else {
        $sqltaxes = 'select * from ivas';
        $resulttaxes = ($con->query($sqltaxes));
        $rowtaxes = [];
        if ($resulttaxes->num_rows > 0) {
            $rowtaxes = $resulttaxes->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowtaxes)) {
        foreach ($rowtaxes as $rowstaxes) {
            echo ('
                    <tr>

                        <td>' . $rowstaxes['ivaid'] . '</td>
                        <td>' . $rowstaxes['ivatype'] . '</td>
                        <td>' . $rowstaxes['ivaperc'] . ' (%)</td>
                    </tr>');
        };
    }
    echo ("                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>

        <div class='p-0 bg-light rounded-3' style='display: inline-flex;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;'>
            <div class='container-fluid  margin-0 padding-0' style='display: inline-flex;'>
                <div class='table-responsive bg-light p-2' style='width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;'>
                    <caption class='sticky-bottom p-2'>
                        " . ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from ivas'))[0] . $localestrings['taxes2show']) . "
                    </caption>
                </div>
            </div>
        </div>
    </div>
    ");
    if ($administrator === true) {
        echo ('<div id="moreactions" class="bg-white border-top bottom sticky sticky-bottom"
        style="width:100%;position:fixed;left:0%;">
        <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;"><button
                class="btn btn-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <p class="m-0 p-0 display-6">' . $localestrings['moreactions'] . '</p>
            </button></div>
        <div class="collapse" id="collapseExample">
    <nav class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-link ml-1 mt-1" id="nav-addtax-tab" data-bs-toggle="tab" href="#nav-addtax" role="tab"
            aria-controls="nav-addtax" aria-selected="true">' . $localestrings['addany'] . ' ' . $localestrings['tax'] . '</a>
        <a class="nav-link ml-1 mt-1" id="nav-deletetax-tab" data-bs-toggle="tab" href="#nav-deletetax" role="tab"
            aria-controls="nav-deletetax" aria-selected="false">' . $localestrings['delany'] . ' ' . $localestrings['tax'] . '</a>
        <a class="nav-link ml-1 mt-1" id="nav-edittax-tab" data-bs-toggle="tab" href="#nav-edittax" role="tab"
            aria-controls="nav-edittax" aria-selected="false">' . $localestrings['editany'] . ' ' . $localestrings['tax'] . '</a>
    </nav>');
    } else {
        echo ("<p class='m-2 p-2'>" . $localestrings['advtaxoptsonlyforadms'] . '</p>');
    }
    echo ("    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-addtax' role='tabpanel' aria-labelledby='nav-addtax-tab'>");
    addtaxpage();
    echo ("
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-deletetax' role='tabpanel' aria-labelledby='nav-deletetax-tab'>");
    deltaxpage();
    echo ("
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-edittax' role='tabpanel' aria-labelledby='nav-edittax-tab'>");
    edittaxpage();
    echo ("
    </div>
</body>
</html>");
}

/*------------------
TAXES ACTIONS PAGES
------------------*/

function addtaxpage()
{
    global $localestrings;
    echo ('<form action="taxactions.php" method="POST">
    <div class="col-10" style=" display:inline-flex;">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="taxname" class="form-label">' . $localestrings['taxname'] . '</label>
            <input type="text" class="form-control" name="taxname" id="taxname" aria-describedby="helpId"
                placeholder="' . $localestrings['taxname'] . '" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="taxpercent" class="form-label">' . $localestrings['taxpercent'] . '</label>
            <input type="number" max="100" class="form-control" name="taxpercent" id="taxpercent"
                aria-describedby="helpId" placeholder="' . $localestrings['taxpercent'] . '" required />
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;display:block">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['tax'] . $localestrings['endconfirm'] . '
            </label>
            <div class="invalid-feedback">
                ' . $localestrings['agreement'] . ' </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;display:block">
        <button style="width:20%;" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['tax'] . '</button>
    </div>
</form>');
};
function deltaxpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM ivas')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['notaxestodel'] . '</p></div>');
    } else {
        echo ('<form action="taxactions.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="deltaxbyid" class="form-label">' . $localestrings['inttaxid'] . '</label>
          <input type="number" class="form-control" name="deltaxbyid" id="deltaxbyid" aria-describedby="helpId" placeholder="' . $localestrings['inttaxid'] . '" required>
          </div>
          <div class="col-3">
          <label for="deltaxbyname" class="form-label">' . $localestrings['taxname'] . '</label>
          <input type="text" class="form-control" name="deltaxbyname" id="deltaxbyname" aria-describedby="helpId" placeholder="' . $localestrings['taxname'] . '" required>
        </div>
        </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
    ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['tax'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '
         </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['tax'] . '</button>
      </div>
      </div>
    </form>');
    };
};
function edittaxpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM ivas')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['notaxestodel'] . '</p></div>');
    } else {
        echo ('
        <form action="taxactions.php" method="POST">
        <div class="p-2 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="seltaxbyid" class="form-label">' . $localestrings['inttaxid'] . '</label>
          <input type="number" class="form-control" name="seltaxbyid" id="seltaxbyid" aria-describedby="helpId" placeholder="' . $localestrings['inttaxid'] . '" required>
        </div>
        <div class="col-3">
        <label for="newtaxname" class="form-label">' . $localestrings['taxname'] . '</label>
        <input type="text" class="form-control" name="newtaxname" id="newtaxname" aria-describedby="helpId" placeholder="' . $localestrings['taxname'] . '">
      </div>
      <div class="col-3">
          <label for="newtaxpercent" class="form-label">' . $localestrings['taxpercent'] . '</label>
          <input type="number" max="100" class="form-control" name="newtaxpercent" id="newtaxpercent" aria-describedby="helpId" placeholder="' . $localestrings['taxpercent'] . '">
        </div>
      </div>
        <div class="col-10" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
    ' . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . '      </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
              </div>
    
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
      <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['savebutton'] . '</button>
      </div>
      </div>
        </form>');
    };
};

/*------------------------------
TAXES ACTIONS (ADD|DELETE|EDIT)
------------------------------*/

function addtax($taxname, $taxpercent)
{
    $con = dbaccess();
    if (!isset($taxname) || !isset($taxpercent)) {
        header('Location:taxes.php');
    } else {
        $action = "INSERT INTO ivas VALUES ('','" . $taxname . "'," . $taxpercent . ');';
    };
    mysqli_real_query($con, $action);
    header('Location:taxes.php');
}
function deltax($deltaxbyid, $deltaxbyname)
{
    $con = dbaccess();
    if (!isset($deltaxbyid) || !isset($deltaxbyname)) {
        header('Location:taxes.php');
    } else {
        $action = 'DELETE FROM ivas WHERE ivaid = ' . $deltaxbyid . " AND ivatype = '" . $deltaxbyname . "';";
    };
    mysqli_real_query($con, $action);
    header('Location:taxes.php');
}
function edittax($seltaxbyid, $newtaxname, $newtaxpercent)
{
    $con = dbaccess();
    if (isset($seltaxbyid)) {
        if (!isset($newtaxname)) {
            $newtaxname = mysqli_fetch_array(mysqli_query($con, 'SELECT ivatype from ivas WHERE ivaid = ' . $seltaxbyid . ';'))[0];
        } else {
            $newtaxname = $_POST['newtaxname'];
        }
        if (!isset($newtaxpercent)) {
            $newtaxpercent = mysqli_fetch_array(mysqli_query($con, 'SELECT ivaperc from ivas WHERE ivaid = ' . $seltaxbyid . ';'))[0];
        } else {
            $newtaxpercent = $_POST['newtaxpercent'];
        };
        $action = "UPDATE ivas set ivatype ='" . $newtaxname . "', ivaperc = " . $newtaxpercent . ' WHERE ivaid = ' . $seltaxbyid . ';';
        mysqli_real_query($con, $action);
    };
    header('Location:taxes.php');
}

/*---------------------
DISCOUNT VOUCHERS PAGE
---------------------*/
function discountvoucherspage()
{
    $con = dbaccess();
    global $localestrings;
    $administrator = admincheck();
    echo ("<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . $localestrings['webmgmt'] . "</title>
</head>
<body>
    <div class='p-0 mb-4 bg-light rounded-3'>
        <div class='container-fluid py-4 margin-0 padding-0'>
            <div class='table-responsive bg-light' style='top:16%;height:55vh;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;'>
                <h3><a href='../manager/webmanager.php'><i class='bi bi-arrow-left-circle'></i></a>" . $localestrings['vouchers'] . "
</h3>
                <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                    <thead>
                        <tr style='position: sticky; top:0;'>
                            <th>" . $localestrings['intvouchid'] . "</th>
                            <th>" . $localestrings['vouchcode'] . "</th>
                            <th>" . $localestrings['vouchdisc'] . "</th>
                            <th>" . $localestrings['vouchdateadded'] . "</th>
                            <th>" . $localestrings['vouchfinaldate'] . "</th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM discountvouchers')) === 0) {
        echo ('<tr>');
        echo ('<td colspan=5>' . $localestrings['vouchnotfound'] . '</td></tr>');
    } else {
        $sqlvouchers = 'select * from discountvouchers';
        $resultvouchers = ($con->query($sqlvouchers));
        $rowvouchers = [];
        if ($resultvouchers->num_rows > 0) {
            $rowvouchers = $resultvouchers->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($rowvouchers)) {
        foreach ($rowvouchers as $rowsvouchers) {
            echo ("
                        <tr>

                            <td>" . $rowsvouchers['vouchid'] . "
        </td>
                            <td>" . $rowsvouchers['voucher'] . "
        </td>
                            <td>" . $rowsvouchers['vouchpercent'] . $localestrings['percent'] . "
        </td>
                            <td>" . $rowsvouchers['creationdate'] . "
        </td>
                            <td>" . $rowsvouchers['finaldate'] . "
        </td>
                        </tr>");
        };
    }
    echo ("
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class='p-0 bg-light rounded-3' style='display: inline-flex;width:-webkit-fill-available'>
            <div class='container-fluid  margin-0 padding-0' style='display: inline-flex;'>
                <div class='table-responsive bg-light p-2' style='width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;'>
                    <caption class='sticky-bottom p-2'>" . ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from discountvouchers'))[0] . $localestrings['vouchers2show']) . "
                    </caption>
                </div>
            </div>
        </div>
    </div>");
    if ($administrator === true) {
        echo ('<div id="moreactions" class="bg-white border-top bottom sticky sticky-bottom"
        style="width:100%;position:fixed;left:0%;">
        <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;"><button
                class="btn btn-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <p class="m-0 p-0 display-6">' . $localestrings['moreactions'] . '</p>
            </button></div>
        <div class="collapse" id="collapseExample">
    <nav class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-link ml-1 mt-1" id="nav-addvoucher-tab" data-bs-toggle="tab" href="#nav-addvoucher" role="tab"
            aria-controls="nav-addvoucher" aria-selected="true">' . $localestrings['addany'] . ' ' . $localestrings['vouchers'] . '</a>
        <a class="nav-link ml-1 mt-1" id="nav-deletevoucher-tab" data-bs-toggle="tab" href="#nav-deletevoucher" role="tab"
            aria-controls="nav-deletevoucher" aria-selected="false">' . $localestrings['delany'] . ' ' . $localestrings['vouchers'] . '</a>
        <a class="nav-link ml-1 mt-1" id="nav-editvoucher-tab" data-bs-toggle="tab" href="#nav-editvoucher" role="tab"
            aria-controls="nav-editvoucher" aria-selected="false">' . $localestrings['editany'] . ' ' . $localestrings['vouchers'] . '</a>
    </nav>');
    } else {
        echo ("<p class='m-2 p-2'>" . $localestrings['voucheradvoptsonlyforadms'] . '</p>');
    }
    echo ("<div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-addvoucher' role='tabpanel'
            aria-labelledby='nav-addvoucher-tab'>");
    addvoucherpage();
    echo ("
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-deletevoucher' role='tabpanel'
            aria-labelledby='nav-deletevoucher-tab'>");
    delvoucherpage();
    echo ("
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-editvoucher' role='tabpanel'
            aria-labelledby='nav-editvoucher-tab'>");
    editvoucherpage();
    echo ("
    </div>
</body>
</html>");
};

/*------------------------------
DISCOUNT VOUCHERS ACTIONS PAGES
------------------------------*/
function addvoucherpage()
{
    global $localestrings;
    echo ('<form action="voucheractions.php" method="POST">
    <div class="col-10" style=" display:inline-flex;">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="vouchername" class="form-label">' . $localestrings['vouchcode'] . '</label>
            <input type="text" class="form-control" name="vouchername" id="vouchername" aria-describedby="helpId"
                placeholder="' . $localestrings['vouchcode'] . '" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="voucherdiscount" class="form-label">' . $localestrings['vouchdisc'] . '</label>
            <input type="number" max="100" class="form-control" name="voucherdiscount" id="voucherdiscount"
                aria-describedby="helpId" placeholder="' . $localestrings['vouchdisc'] . '" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="finaldate" class="form-label">' . $localestrings['vouchfinaldate'] . '</label>
            <input type="date" class="form-control" name="finaldate" id="finaldate" aria-describedby="helpId"
                placeholder="' . $localestrings['vouchfinaldate'] . '" required />
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;display:block">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['vouchers'] . $localestrings['endconfirm'] . '
            </label>
            <div class="invalid-feedback">
                ' . $localestrings['agreement'] . ' </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;display:Block">
        <button style="width:20%;" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['vouchers'] . '</button>
    </div>
    </div>
</form>');
}
function delvoucherpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM discountvouchers')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['novoucherstodel'] . '</p></div>');
    } else {
        echo ('<form action="voucheractions.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="delvoucherbyid" class="form-label">' . $localestrings['intvouchid'] . '</label>
          <input type="number" class="form-control" name="delvoucherbyid" id="delvoucherbyid" aria-describedby="helpId" placeholder="' . $localestrings['intvouchid'] . '" required>
          </div>
          <div class="col-3">
          <label for="delvoucherbyname" class="form-label">' . $localestrings['vouchcode'] . '</label>
          <input type="text" class="form-control" name="delvoucherbyname" id="delvoucherbyname" aria-describedby="helpId" placeholder="' . $localestrings['vouchcode'] . '" required>
        </div>
        </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['vouchers'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['vouchers'] . '</button>
      </div>
      </div>
    </form>');
    };
}
function editvoucherpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM discountvouchers')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
        echo ('<p>' . $localestrings['novoucherstoedit'] . '</p></div>');
    } else {
        echo ('
        <form action="voucheractions.php" method="POST">
        <div class="p-2 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="selvoucherbyid" class="form-label">' . $localestrings['intvouchid'] . '</label>
          <input type="number" class="form-control" name="selvoucherbyid" id="selvoucherbyid" aria-describedby="helpId" placeholder="' . $localestrings['intvouchid'] . '" required>
        </div>
        <div class="col-3">
        <label for="newvouchername" class="form-label">' . $localestrings['vouchcode'] . '</label>
        <input type="text" class="form-control" name="newvouchername" id="newvouchername" aria-describedby="helpId" placeholder="' . $localestrings['vouchcode'] . '">
      </div>
      <div class="col-3">
          <label for="newvoucherpercent" class="form-label">' . $localestrings['vouchdisc'] . '</label>
          <input type="number" max="100" class="form-control" name="newvoucherpercent" id="newvoucherpercent" aria-describedby="helpId" placeholder="' . $localestrings['vouchdisc'] . '">
        </div>
        </div>
        <div class="p-2 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    <div class="col-3">
          <label for="newcreationdate" class="form-label">' . $localestrings['vouchdateadded'] . '</label>
          <input type="date" class="form-control" name="newcreationdate" id="newcreationdate" aria-describedby="helpId" placeholder="' . $localestrings['vouchdateadded'] . '" required>
        </div>
        <div class="col-3">
        <label for="newfinaldate" class="form-label">' . $localestrings['vouchfinaldate'] . '</label>
        <input type="date" class="form-control" name="newfinaldate" id="newfinaldate" aria-describedby="helpId" placeholder="' . $localestrings['vouchfinaldate'] . '">
      </div>
      </div>
        <div class="col-10" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
    ' . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . '      </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>      </div>
    
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
      <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['savebutton'] . '</button>
      </div>
      </div>
        </form>');
    };
}
/*-----------------------------------------
DISCOUNT VOUCHER ACTIONS (ADD|DELETE|EDIT)
-----------------------------------------*/
function addvoucher($vouchername, $voucherdiscount, $finaldate)
{
    $con = dbaccess();
    if (!isset($vouchername) || !isset($voucherdiscount) || !isset($finaldate)) {
        header('Location:vouchers.php');
    } else {
        $action = "INSERT INTO discountvouchers VALUES ('','" . $vouchername . "'," . $voucherdiscount . ",'" . mysqli_fetch_array(mysqli_query($con, 'SELECT date(now());'))[0] . "','" . $finaldate . "')";
        mysqli_real_query($con, $action);
    }
    header('Location:vouchers.php');
}

function delvoucher($delvoucherbyid, $delvoucherbyname)
{
    $con = dbaccess();
    if (!isset($delvoucherbyid) || !isset($delvoucherbyname)) {
        header('Location:vouchers.php');
    } else {
        $action = 'DELETE FROM discountvouchers WHERE vouchid = ' . $delvoucherbyid . " AND voucher = '" . $delvoucherbyname . "';";
        mysqli_real_query($con, $action);
    };
    header('Location:vouchers.php');
}

function editvoucher($selvoucherbyid, $newvouchername, $newvoucherpercent, $newcreationdate, $newfinaldate)
{
    $con = dbaccess();
    if (isset($selvoucherbyid)) {
        if (!isset($newvouchername)) {
            $vouchername = mysqli_fetch_array(mysqli_query($con, 'SELECT voucher from discountvouchers WHERE vouchid = ' . $_POST['selvoucherbyid'] . ';'))[0];
        } else {
            $vouchername = $newvouchername;
        };
        if (!isset($newvoucherpercent)) {
            $voucherpercent = mysqli_fetch_array(mysqli_query($con, 'SELECT vouchpercent from discountvouchers WHERE vouchid = ' . $_POST['selvoucherbyid'] . ';'))[0];
        } else {
            $voucherpercent = $newvoucherpercent;
        };
        if (!isset($newcreationdate)) {
            $creationdate = mysqli_fetch_array(mysqli_query($con, 'SELECT creationdate from discountvouchers WHERE vouchid = ' . $_POST['selvoucherbyid'] . ';'))[0];
        } else {
            $creationdate = $newcreationdate;
        };
        if (!isset($newfinaldate)) {
            $finaldate = mysqli_fetch_array(mysqli_query($con, 'SELECT finaldate from discountvouchers WHERE vouchid = ' . $_POST['selvoucherbyid'] . ';'))[0];
        } else {
            $finaldate = $newfinaldate;
        }
        $action = "UPDATE discountvouchers set voucher ='" . $vouchername . "', vouchpercent = " . $voucherpercent . ", creationdate = '" . $creationdate . "',finaldate = '" . $finaldate . "' WHERE vouchid = " . $selvoucherbyid . ';';
        mysqli_real_query($con, $action);
    };
    header('Location:vouchers.php');
}

/*-----------
PROFILE PAGE
-----------*/
function profile()
{
    $con = dbaccess();
    global $localestrings;
    echo ("<!DOCTYPE html>
<html class = 'bg-light' lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>

<title>" . $localestrings['webmgmt'] . "</title>
</head>

<body class = 'bg-light'>
<div class = 'p-0 mb-4 bg-light rounded-3'>
<div class = 'container-fluid py-4 margin-0 padding-0'>
<h3><a href = '../manager/webmanager.php'><i class = 'bi bi-arrow-left-circle'></i></a>" . $localestrings['userinfo'] . "</h3>

<div class ='bg-light'>
<table class = 'table-responsive table table-striped table-hover table-borderless table-primary align-middle'>
<thead>
<tr style = 'position: sticky; top:0;'>
<th>" . $localestrings['intid'] . "</th>
<th>" . $localestrings['username'] . "</th>
<th>" . $localestrings['userdesc'] . "</th>
<th>" . $localestrings['userpass'] . "</th>
</tr>
</thead>
<tbody class = 'table-group-divider'>");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM users')) === 0) {
        echo ('<tr><td colspan=10>' . $localestrings['msguser1'] . '</td></tr>');
        echo ('<tr><td colspan=10>' . $localestrings['msguser2'] . '</td></tr>');
        echo ('<tr><td colspan=10>' . $localestrings['msguser3'] . '</td></tr>');
    } else {
        $sql = "select * from users where username = '" . $_SESSION['name'] . "';";
        $result = ($con->query($sql));
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($row)) {
        foreach ($row as $rows) {
            echo ('
        <tr>
        <td>' . $rows['userid'] . '</td>
        <td>' . $rows['username'] . '</td>
        <td>' . $rows['realname'] . '</td>
        <td>' . '*****' . '</td>
        </tr>');
        };
    }
    echo ("
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
    </table>
    </div></div>
    <div id='moreactions' class='bg-white border-top bottom sticky sticky-bottom'
    style='width:100%;position:fixed;left:0%;'>
    <div class='sticky sticky-bottom' style='bottom:0%;z-index:12500;top:0%;left:0%;display:block;'><button
            class='btn btn-primary' type='button' data-bs-toggle='collapse'
            data-bs-target='#collapseExample' aria-expanded='false' aria-controls='collapseExample'>
            <p class='m-0 p-0 display-6'>" . $localestrings['edituser'] . "</p>
        </button></div>
    <div class='collapse' id='collapseExample'>
    <nav class = 'nav nav-pills p-3' id = 'nav-tab' role = 'tablist'>
    ");

    /*-------------
USER EDIT PAGE
-------------*/
    edituserpage();
    echo ("
    </nav>
    </div>
    </footer>
    </body>
    </html>");
}
function edituserpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM users')) === 0) {
        echo ("<div class='col-12 bg-light'>");
        echo ('<p>' . $localestrings['msgdeluser1'] . '</p>');
        echo ('<p>' . $localestrings['msgdeluser2'] . '</p>');
        echo ('<p>' . $localestrings['msgdeluser3'] . '</p></div>');
    } else {
        echo ('
        <form action="useractions.php" method="POST">
        <div class="p-4 col-10" style="display:inline-flex;">
                <span class="navbar-toggler-icon"></span>
            </button>    
      <div class="col-3">
          <label for="newuserdesc" class="form-label">' . $localestrings['userdesc'] . '</label>
          <input type="text" class="form-control" name="newuserdesc" id="newuserdesc" aria-describedby="helpId" placeholder="' . $localestrings['userdesc'] . '">
        </div>
        <div class="col-3">
        <label for="newuserpass" class="form-label">' . $localestrings['userpass'] . '</label>
        <input type="password" class="form-control" name="newuserpass" id="newuserpass" aria-describedby="helpId" placeholder="' . $localestrings['userpass'] . '">
      </div>
        </div>
        <div class="col-10 p-4" style="display:inline-flex;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            ' . $localestrings['datacheck'] . $localestrings['savebutton'] . $localestrings['endconfirm'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>      </div>
    
      <div class="col-12 p-4" style="display:inline-flex; padding-left:2em; padding-top:1em;">
      <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['savebutton'] . '</button>
      </div>
      </div>
        </form>');
    };
};
/*---------------------------------------
USER EDITION (RESTRICTED TO ACTUAL USER)
---------------------------------------*/
function useredit($newuserdesc, $newuserpassunenc)
{
    $con = dbaccess();
    if (!isset($newuserdesc) || $newuserdesc === '' || $newuserdesc === NULL) {
        $userdesc = mysqli_fetch_array(mysqli_Query($con, "SELECT realname from users where username = '" . $_SESSION['name'] . "';"))[0];
    } else {
        $userdesc = $newuserdesc;
    };
    if (!isset($newuserpassunenc) || $newuserpassunenc === '' || $newuserpassunenc === NULL) {
        $userpass = mysqli_fetch_array(mysqli_Query($con, "SELECT password from users where username = '" . $_SESSION['name'] . "';"))[0];
    } else {
        $userpass = hash("sha512", $newuserpassunenc);
    };
    $action = "UPDATE users set realname = '" . $userdesc . "', password = '" . $userpass . "' WHERE username = '" . $_SESSION['name'] . "';";
    mysqli_real_query($con, $action);
    header('Location:profile.php');
}
/*--------------------
USERS PAGE FOR ADMINS
--------------------*/
function usersadmpage()
{
    $con = dbaccess();
    global $localestrings;
    $administrator = admincheck();
    echo ("    <!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
    <link rel='icon' href='../src/images/favicon/favicon.svg' />
    <title>" . $localestrings['webmgmt'] . "</title>
</head>
<body>
    <div class='p-0 mb-4 bg-light rounded-3'>
        <div class='container-fluid py-4 margin-0 padding-0'>
            <h3><a href='../manager/webmanager.php'><i class='bi bi-arrow-left-circle'></i></a>" . $localestrings['userinfo'] . "</h3>
            <div class='table-responsive bg-light' style='height:369px;overflow-y:scroll;'>
                <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                    <thead>
                        <tr style='position: sticky; top:0;'>
                            <th>" . $localestrings['usersuserid'] . "</th>
                            <th>" . $localestrings['username'] . "</th>
                            <th>" . $localestrings['userdesc'] . "</th>
                            <th>" . $localestrings['userpass'] . "</th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM users')) === 0) {
        echo ("<tr><td colspan=10>" . $localestrings['msguser1'] . "</td></tr>");
        echo ("<tr><td colspan=10>" . $localestrings['msguser2'] . "</td></tr>");
        echo ("<tr><td colspan=10>" . $localestrings['msguser3'] . "</td></tr>");
    } else {
        $sql = 'select * from users';
        $result = ($con->query($sql));
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($row)) {
        foreach ($row as $rows) {

            echo ("                    <tr>

                            <td>" . $rows['userid'] . "</td>
                            <td>" . $rows['username'] . "</td>
                            <td>" . $rows['realname'] . "</td>
                            <td>" . '*****' . "</td>

                        </tr>");
        };
    }

    echo (" </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <caption class='sticky-bottom'>" . ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from users'))[0] . $localestrings['users2show']) . "</caption>

        </div>
    </div>");
    if ($administrator === true) {
        echo ('<div id="moreactions" class="bg-white border-top bottom sticky sticky-bottom"
        style="width:100%;position:fixed;left:0%;">
        <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <p class="m-0 p-0 display-6">' . $localestrings['moreactions'] . '</p>
        </button></div>
        <div class="collapse" id="collapseExample">
  <nav class="nav nav-pills" id="nav-tab" role="tablist">
  <a class="nav-link ml-1 mt-1" id="nav-adduser-tab" data-bs-toggle="tab" href="#nav-adduser" role="tab" aria-controls="nav-adduser" aria-selected="true">' . $localestrings['addany'] . ' ' . $localestrings['user'] . '</a>
  <a class="nav-link ml-1 mt-1" id="nav-deleteuser-tab" data-bs-toggle="tab" href="#nav-deleteuser" role="tab" aria-controls="nav-deleteuser" aria-selected="false">' . $localestrings['delany'] . ' ' . $localestrings['user'] . '</a>
</nav>');
    } else {
        echo ("<p class='m-2 p-2'>" . $localestrings['advuseroptsonlyforadms'] . "</p>");
    };
    echo ("<div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-adduser' role='tabpanel' aria-labelledby='nav-adduser-tab'>");
    adduserpage();
    echo ("
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-deleteuser' role='tabpanel'
            aria-labelledby='nav-deleteuser-tab'>");
    deluserpage();
    echo ("
            </div>
    </div>
</body>
</html>");
};
/*-----------------
USER ACTIONS PAGES
-----------------*/
function adduserpage()
{
    global $localestrings;
    echo ('<form action="useractions.php" method="POST">
    <div class="col-10">
        <div class="col-4" style="padding-left:2em; padding-top:1em;display:inline-flex;">
            <div class="col-6">
                <label for="newusern" class="form-label">' . $localestrings['username'] . '</label>
                <input type="text" class="form-control" name="newusern" id="newusern" aria-describedby="helpId"
                    placeholder="' . $localestrings['username'] . '" required />
            </div>
            <div class="col-6">
                <label for="newuserdesc" class="form-label">' . $localestrings['userdesc'] . '</label>
                <input type="text" class="form-control" name="newuserdesc" id="newuserdesc" aria-describedby="helpId"
                    placeholder="' . $localestrings['userdesc'] . '" required />
            </div>
            <div class="col-6">
                <label for="newuserpass" class="form-label">' . $localestrings['userpass'] . '</label>
                <input type="password" class="form-control" name="newuserpass" id="newuserpass"
                    aria-describedby="helpId" placeholder="' . $localestrings['userpass'] . '" required />
            </div>
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                ' . $localestrings['datacheck'] . $localestrings['addany'] . " " . $localestrings['user'] . $localestrings['endconfirm'] . '
            </label>
            <div class="invalid-feedback">
                ' . $localestrings['agreement'] . '</div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%;" class="btn btn-primary" type="submit">' . $localestrings['addany'] . " " . $localestrings['user'] . '</button>
    </div>
    </div>
</form>');
}
function deluserpage()
{
    $con = dbaccess();
    global $localestrings;
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM users')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em;'>");
        echo ('<p>' . $localestrings['msgdeluser1'] . '</p>');
        echo ('<p>' . $localestrings['msgdeluser2'] . '</p>');
        echo ('<p>' . $localestrings['msgdeluser3'] . '</p></div>');
    } else {
        echo ('<form action="useractions.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="deluserbyid" class="form-label">' . $localestrings['usersuserid'] . '</label>
          <input type="number" class="form-control" name="deluserbyid" id="deluserbyid" aria-describedby="helpId" placeholder="' . $localestrings['usersuserid'] . '" required>
          </div>
          <div class="col-3">
          <label for="deluserbyname" class="form-label">' . $localestrings['username'] . '</label>
          <input type="text" class="form-control" name="deluserbyname" id="deluserbyname" aria-describedby="helpId" placeholder="' . $localestrings['username'] . '" required>
        </div>
        </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            ' . $localestrings['datacheck'] . $localestrings['delany'] . ' ' . $localestrings['user'] . $localestrings['endconfirm'] . $localestrings['actionnotreversible'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['delany'] . ' ' . $localestrings['user'] . '</button>
      </div>
      </div>
    </form>');
    };
}

/*---------------------------------------
USER ACTIONS (ADD|DELETE)
EDITING IS RESTRICTED TO THE ACTUAL USER
---------------------------------------*/
function adduser($username, $userrealname, $passwordunenc)
{
    $con = dbaccess();
    if (!isset($username) || !isset($userrealname) || !isset($userdescription) || !isset($passwordunenc)) {
        header('Location:users.php');
    } else {
        $passwordenc = hash("sha512", $passwordunenc);
        $action = "INSERT INTO users VALUES('','" . $username . "','" . $userrealname . "','" . $passwordenc . "';";
    };
    mysqli_real_query($con, $action);
    header('Location:users.php');
};

function deluser($deluserbyid, $deluserbyname)
{
    $con = dbaccess();
    global $localestrings;
    if (!isset($deluserbyid) || !isset($deluserbyname)) {
        exit($localestrings['cantdeluser']);
    } elseif ($deluserbyid === mysqli_fetch_array(mysqli_query($con, "SELECT userid from users where username LIKE %admin%;"))[0] || $deluserbyname === mysqli_fetch_array(mysqli_query($con, "SELECT username from users where username LIKE %admin%;"))[0]) {
        header('Location:users.php');
    } else {
        $action = "DELETE FROM users where userid = '" . $deluserbyid . "' and username = '" . $deluserbyname . "';";
    };
    mysqli_real_query($con, $action);
    header('Location:users.php');
};

/*-------------------
LANGUAGE CHANGE PAGE
-------------------*/
function langchangepage()
{
    $con = dbaccess();
    global $localestrings;
    $administrator = admincheck();
    echo ("<!DOCTYPE html>
<html>
<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<link rel = 'icon' href = '../src/images/favicon/favicon.svg'/>
<title>" . $localestrings['webmgmt'] . "</title>
</head>
<body>
<div class = 'p-0 mb-4 bg-light rounded-3'>
<div class = 'container-fluid py-4 margin-0 padding-0'>
<h3><a href = '../manager/webmanager.php'><i class = 'bi bi-arrow-left-circle'></i></a>" . $localestrings['language'] . "</h3>
<div class = 'table-responsive bg-light' style = 'height:369px;overflow-y:scroll;'>
<table class = 'table table-striped table-hover table-borderless table-primary align-middle'>
<thead>
<tr style = 'position: sticky; top:0;'>
<th>" . $localestrings['intlangid'] . "</th>
<th>" . $localestrings['textlangid'] . "</th>
<th>" . $localestrings['country'] . "</th>
<th>" . $localestrings['tablestorename']
        . "</th>
<th>" . $localestrings['currency']
        . "</th>
<th>" . $localestrings['selectedlang']
        . "</th>
</tr>
</thead>
<tbody class = 'table-group-divider'>
");
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * from locales order by selected desc;')) === 0) {
        echo ('<tr><td colspan=10>".$msglocales1."</td></tr>');
    } else {
        $sql = 'SELECT * from locales ORDER BY selected desc;';
        $result = ($con->query($sql));
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_all(MYSQLI_ASSOC);
        };
    };
    if (!empty($row)) {
        foreach ($row as $rows) {

            echo ("
        <tr>
        <td>" . $rows["localeid"]
                . "</td>
        <td>" . $rows["localetextid"]
                . "</td>
        <td>" . $rows["localecountry"]
                . "</td>
        <td>" . $rows["storename"]
                . "</td>
        <td>" . $rows["currency"]
                . "</td>
        <td>");
            if ($rows['selected'] != NULL) {
                echo 'Y';
            } else {
                echo 'N';
            }
            echo ("</td>
        </tr>");
        };
    }
    echo ("
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
    </table>
    </div>
    <caption class = 'sticky-bottom'>" . ('(' . mysqli_fetch_array(mysqli_query($con, 'SELECT count(*) from locales'))[0] . $localestrings['locales2show']) . "</caption>

    </div>
    </div>");
    if ($administrator === true) {
        echo ('<div id="moreactions" class="bg-white border-top bottom sticky sticky-bottom"
        style="width:100%;position:fixed;left:0%;">
        <div class="sticky sticky-bottom" style="bottom:0%;z-index:12500;top:0%;left:0%;display:block;">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <p class="m-0 p-0 display-6">' . $localestrings['language'] . '</p>
        </button></div>
        <div class="collapse" id="collapseExample">');
        langchange();
        echo ('
        </div>
        </div>
        </div>
    ');
    } else {
        echo ("<p class='m-2 p-2'>" . $localestrings['advuseroptsonlyforadms'] . '</p>');
    };


    echo ("
    </body>
    </html>");
}

/*--------------------
LANGUAGE CHANGE QUERY
--------------------*/
function langchange()
{
    $con = dbaccess();
    global $localestrings;
    $administrator = admincheck();
    if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM LOCALES')) === 0) {
        echo ("<div class='col-12' style='padding-left:2em; padding-top:1em;'>");
        echo ('<p>' . $localestrings['msginvoice1'] . '</p>');
    } else {
        echo ('<form action="completelangchange.php" enctype="multipart/form-data" method="POST">
        <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
            <div class="col-3">
            <label for="textlangid" class="form-label">' . $localestrings['textlangid'] . '</label>
            <select class="form-select" name="textlangid" id="textlangid" aria-label=' . $localestrings['textlangid'] . '>');
        $sqllocales = 'select * from locales;';
        $resultlocales = ($con->query($sqllocales));
        $rowlocales = [];
        if ($resultlocales->num_rows > 0) {
            $rowlocales = $resultlocales->fetch_all(MYSQLI_ASSOC);
        };
        if (!empty($rowlocales))
            foreach ($rowlocales as $rowslocales) {

                echo ('<option value=' . $rowslocales['localeid'] . '>' . $rowslocales['localetextid'] . '</option>');
            }
        else {
            echo ("
    <option disabled value='0'>" . $localestrings['msglocales1'] . "</option>
    <option disabled>" . $localestrings['msglocales1'] . '</option>');
        }
        echo ('</select>
          </div>
          </div>
            <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="changelang" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            ' . $localestrings['datacheck'] . $localestrings['changelang'] . $localestrings['endconfirm'] . '
          </label>
          <div class="invalid-feedback">
    ' . $localestrings['agreement'] . '      </div>
        </div>
      </div>
      <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit">' . $localestrings['changelang'] . '</button>
      </div>
      </div>
    </form>');
    };
}
