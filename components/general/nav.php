<?php 
    $path = isset($_GET['path']) ? $_GET['path'] : 'kea';

?>

<li class="menu-item">
    <a href="index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-dashboard"></i>
        <div data-i18n="Analytics">Beranda</div>
    </a>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-detail"></i>
        <div data-i18n="Account Settings">General</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="data.php?id=personal" class="menu-link">
                <div data-i18n="Account"><small>Data Personal Saya</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=bpjs" class="menu-link">
                <div data-i18n="Notifications"><small>BPJS Saya dan Keluarga</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=apps" class="menu-link">
                <div data-i18n="Notifications"><small>Aplikasi Saya</small></div>
            </a>
        </li>  
    </ul>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-inbox"></i>
        <div data-i18n="Account Settings">Tiket</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="data.php?id=myticket" class="menu-link">
                <div data-i18n="Account"><small>Tiket saya</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=inbox" class="menu-link">
                <div data-i18n="Notifications"><small>Tiket masuk</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=logticket" class="menu-link">
                <div data-i18n="Notifications"><small>Log tiket</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=preference" class="menu-link">
                <div data-i18n="Notifications"><small>Preferensi tiket</small></div>
            </a>
        </li>  
    </ul>
</li>


<?php if($path == 'hrd') { ?>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-user-account"></i>
        <div data-i18n="Account Settings">Menu HR</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="data.php?id=orgz" class="menu-link">
                <div data-i18n="Account"><small>Data Organisasi</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=branch" class="menu-link">
                <div data-i18n="Notifications"><small>Data Cabang</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=dirs" class="menu-link">
                <div data-i18n="Notifications"><small>Data Direktorat</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=division" class="menu-link">
                <div data-i18n="Notifications"><small>Data Divisi</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=depts" class="menu-link">
                <div data-i18n="Notifications"><small>Data Departemen</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=grade" class="menu-link">
                <div data-i18n="Notifications"><small>Data Grade</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=status" class="menu-link">
                <div data-i18n="Notifications"><small>Data Status</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=employee" class="menu-link">
                <div data-i18n="Notifications"><small>Data Karyawan</small></div>
            </a>
        </li>  
    </ul>
</li>
<?php } ?>

<?php if($path == 'ict') { ?>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-devices"></i>
        <div data-i18n="Account Settings">Menu ICT</div>
    </a>
    <ul class="menu-sub">
       
        <li class="menu-item">
            <a href="data.php?id=app" class="menu-link">
                <div data-i18n="Notifications"><small>Data Aplikasi</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=access" class="menu-link">
                <div data-i18n="Notifications"><small>Data Akses</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=visitor" class="menu-link">
                <div data-i18n="Notifications"><small>Data Akses Visitor</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=macradius" class="menu-link">
                <div data-i18n="Notifications"><small>Data Bypass Wifi</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=license" class="menu-link">
                <div data-i18n="Notifications"><small>Lisensi Users</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=corus" class="menu-link">
                <div data-i18n="Notifications"><small>Perubahan s/n Corus</small></div>
            </a>
        </li>
    </ul>
</li>

<?php } ?>

<?php if($path == 'kea') { ?>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Account Settings">Menu Keuangan</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="data.php?id=datasource" class="menu-link">
                <div data-i18n="Notifications"><small>Kode Datasource</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=report" class="menu-link">
                <div data-i18n="Notifications"><small>Kode Laporan</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=coa" class="menu-link">
                <div data-i18n="Notifications"><small>Master COA</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=bank" class="menu-link">
                <div data-i18n="Notifications"><small>Kode Bank</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=rekening" class="menu-link">
                <div data-i18n="Notifications"><small>Rekening Bank</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=providers" class="menu-link">
                <div data-i18n="Notifications"><small>Data Produsen</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=customer" class="menu-link">
                <div data-i18n="Notifications"><small>Data Customer</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=vendor" class="menu-link">
                <div data-i18n="Notifications"><small>Data vendor</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=personincharge" class="menu-link">
                <div data-i18n="Notifications"><small>Data PIC</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=penerima" class="menu-link">
                <div data-i18n="Notifications"><small>Data Penerima</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=currency" class="menu-link">
                <div data-i18n="Notifications"><small> Data Mata Uang</small></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="data.php?id=budget" class="menu-link">
                <div data-i18n="Notifications"><small>Data Budget</small></div>
            </a>
        </li>
    </ul>
</li>

<?php } ?>

<?php if($path == 'prc') { ?>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cart"></i>
        <div data-i18n="Account Settings">Menu Procurement</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="data.php?id=warehouse" class="menu-link">
                <div data-i18n="Notifications"><small>Data Gudang</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=itemmeasure" class="menu-link">
                <div data-i18n="Notifications"><small>Data Satuan Item</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=itemtype" class="menu-link">
                <div data-i18n="Notifications"><small>Data Tipe Item</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=itemcategory" class="menu-link">
                <div data-i18n="Notifications"><small>Data Kategori Item</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=items" class="menu-link">
                <div data-i18n="Notifications"><small>Data Item</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=payment" class="menu-link">
                <div data-i18n="Notifications"><small>Data Termin Pembayaran</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=groupsupplier" class="menu-link">
                <div data-i18n="Notifications"><small>Data Kategori Vendor</small></div>
            </a>
        </li>  
        <li class="menu-item">
            <a href="data.php?id=supplier" class="menu-link">
                <div data-i18n="Notifications"><small>Data  Vendor</small></div>
            </a>
        </li>  
    </ul>
</li>
    

<?php } ?>

<script type="text/javascript">
    
</script>