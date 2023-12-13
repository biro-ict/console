<?php 
    $user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog  modal-xl modal-dialog-centered modal-dialog-scrollable" id="modal_content">
      
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Vendor</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select  class="form-select form-select-sm" placeholder="Cari" id="cari"></select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height: 400px">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background: white; position: sticky; top: 0;box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);">
                                        <th class="col">#</th>
                                        <th class="col">ID</th>
                                        <th class="col">Nama</th>
                                        <th class="col">Group</th>
                                        <th class="col">Alamat</th>
                                        <th class="col">Kode Pos</th>
                                        <th class="col">Telp</th>
                                        <th class="col">HP</th>
                                        <th class="col">Fax</th>
                                        <th class="col">Email</th>
                                        <th class="col">Catatan</th>
                                        <th class="col">Contact Person</th>
                                    </thead>
                                    <tbody id="tbl-supplier"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="card-footer mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addSupplier">Tambah</button>
                    <button type="button" class="btn btn-info btn-sm" id="updateSupplier">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteSupplier">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" id="backto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#backto').on('click', function() {
        window.history.go(-1)
    })

    $('#addSupplier').on('click', function() {
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/prc/formSupplier.php',
            type: 'get',
            data: {user:user},
            success: function(res) {
                $('#content-user').html(res)
            }
        })
    })

    $('#updateSupplier').on('click', function() {
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            return Swal.fire(
                'Peringatan',
                'Silahkan pilih supplier terlebih dahulu',
                'warning'
            )
        } 
        if(totals > 1) {
            return Swal.fire(
                'Peringatan',
                'Kamu hanya bisa memilih satu supplier saja',
                'warning'
            )
        }

        var id = document.querySelector('.checked:checked').value
        var user = `<?php echo $user;?>`;
        $.ajax({
            url: '../components/prc/formSupplier.php',
            type: 'get',
            data: {user:user, id: id},
            success: function(res) {
                $('#content-user').html(res)
            }
        })  
    })

    $('#deleteSupplier').on('click', function() {
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire(
                'Peringatan',
                'Silahkan pilih supplier terlebih dahulu',
                'warning'
            )
        }else {
            $('#tbl-supplier input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row) 
            })
        
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Data ini akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: url_api + '/supplier/delete',
                        type: 'post',
                        data: {
                            id: array, 
                            updatedby: users,
                        },
                        success: function(res) {
                           Swal.fire(res.title, res.message, res.status);
                           if(res.status == 'success') show_tables($('#cari').val())
                        }
                    })
                }else{
                    Swal.fire('Batal', 'Data batal dihapus', 'error')
                }
            })
        }
    })

    function show_tables(id) {
        url = id == '-' ?  url_api + '/supplier' :  url_api + '/supplierByGroup/'+id
        $.ajax({
            url: url,
            type: 'get',
            success: function(res) {
                var data = res.data
                var tb = ''
                data.forEach(function(items, index) {
                    tb = tb + `<tr>
                             <td class="col-1"><input type="checkbox" class="form-check-input  checked" value="${items.cardcode}"> </td>
                            <td><b>${items.cardcode}</b></td>
                            <td>${items.cardname}</td>
                            <td>${items.groupid}</td>
                            <td>${items.alamat}</td>
                            <td>${items.kodepos}</td>
                            <td>${items.phone1}</td>
                            <td>${items.phone2}</td>
                            <td>${items.fax}</td>
                            <td>${items.mailaddres}</td>
                            <td>${items.notes}</td>
                            <td>
                                <button class="btn btn-sm btn-success" type="button"  onclick="view_contact('${items.cardcode}', '${items.cardname}')">Lihat Kontak</button>
                            </td>
                            </tr>`
                })

                $('#tbl-supplier').html(tb)
            }
        })
    }

    $('#cari').on('change', function() {
        var value = $(this).val()
        show_tables(value)
    })

    $(document).ready(function() {
        $.ajax({
            url: url_api + '/groupsupplier',
            type: 'post',
            success: function(res) {
                var data = res.data
                var opt = '<option value="-">Semua</option>'
                data.forEach(function(items, index) {
                    opt = opt + `<option value="${items.bpgroupid}">${items.bpgroupname}</option>`
                })

                $('#cari').html(opt)
            }
        })
        show_tables('-')
    })

 
    function view_contact(id, name) {
        $.ajax({
            url: url_api + '/contactsupplier',
            type: 'post',
            data: {
                id: id
            },
            success: function(res) { 
                var modal = `  
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact Person: ${name}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover table-bordered">
                                    <thead>
                                        <tr  class="d-flex">
                                            <th class="col-1">#</th>
                                            <th class="col-6">Nama Kontak</th>
                                            <th class="col-6">Profesi</th>
                                            <th class="col-6">Email</th>
                                            <th class="col-6">Telp</th>
                                            <th class="col-6">HP</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-contact">`;
                if(res.status == 'success')     {
                    var data = res.data == undefined ? 0 : res.data;
                    if(data.length > 0) {
                        data.forEach(function(item, index) {
                            modal = modal + `   
                            <tr class="d-flex">
                            <td class="col-1"><input type="checkbox" class="form-check-input checked-contact" value="${item.contactcode}"> </td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="contactname[]" value="${item.contactname}"></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="profession[]" value="${item.profession}"></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="mailaddr[]" value="${item.mailaddress}"></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="phone1[]" value="${item.phone1}"></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="cellular[]" value="${item.cellular}"></td>
                            </tr>`;
                        })
                    }
                }else {
                        modal = modal + `   
                        <tr class="d-flex">
                            <td class="col-1"><input type="checkbox" class="form-check-input checked-contact" value=""> </td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="contactname[]" ></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="profession[]"></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="mailaddr[]" ></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="phone1[]" ></td>
                            <td class="col-6"><input type="text" class="form-control form-control-sm" name="cellular[]"></td>
                        </tr>`;
                }
          

                modal = modal + `
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addfield()">Tambah Kontak</button>
                    <button type="button" class="btn btn-success" onclick="savecontact('${id}')">Simpan Perubahan</button>
                    <button type="button" class="btn btn-danger" onclick="deletecontact('${id}')">Hapus Kontak</button>
                </div>
            </div>`;

            $('#modal_content').html(modal)
            $('#exampleModal').modal('show')
                
            }
        })
        
    }

    function addfield() {
        
        var data = `   
            <tr class="d-flex">
                <td class="col-1"><input type="checkbox" class="form-check-input checked-contact" value=""> </td>
                <td class="col-6"><input type="text" class="form-control form-control-sm" name="contactname[]" ></td>
                <td class="col-6"><input type="text" class="form-control form-control-sm" name="profession[]"></td>
                <td class="col-6"><input type="text" class="form-control form-control-sm" name="mailaddr[]" ></td>
                <td class="col-6"><input type="text" class="form-control form-control-sm" name="phone1[]" ></td>
                <td class="col-6"><input type="text" class="form-control form-control-sm" name="cellular[]"></td>
            </tr>`
        $('#tbl-contact').append(data)
    }

    function savecontact(code) {
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked-contact')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire({
                title: 'Kontak di daftar kamu sudah kosong!',
                icon: 'warning',
                position: 'bottom-end',
                timer: 1500
            })
            $('#exampleModal').modal('hide')
        }else {

            var contactname = document.getElementsByName('contactname[]')
            var profession = document.getElementsByName('profession[]')
            var mailaddr = document.getElementsByName('mailaddr[]')
            var phone1 = document.getElementsByName('phone1[]')
            var cellular = document.getElementsByName('cellular[]')
            var name    = [];
            var proff   = [];
            var email   = [];
            var telp    = [];
            var nohp    = [];

            for(i=0;i<totals;i++) {
                name.push(contactname[i].value)
                proff.push(profession[i].value)
                email.push(mailaddr[i].value)
                telp.push(phone1[i].value)
                nohp.push(cellular[i].value)
            }
            
            

            //change update or save
            $('#tbl-contact input[type=checkbox]').each(function() {
                var row = $(this).val()
                array.push(row) 

              
            })

            $.ajax({
                url: url_api + '/contactsupplier/update',
                type: 'post',
                data: {
                    id: array,
                    code: code,
                    name: name,
                    profession: proff,
                    email: email,
                    telp: telp,
                    nohp: nohp,
                    updatedby: users
                },
                success: function(res) {
                    Swal.fire(res.title, res.message, res.status) 
                    if(res.status == 'success') {
                       $('#exampleModal').modal('hide')
                       show_tables($('#cari').val())
                    }
                }
            })    
        }
    }

    function deletecontact(id){
        var users = `<?php echo $user;?>`;
        var checkbox = document.querySelectorAll('.checked-contact:checked')
        var array = []
        var totals = checkbox == undefined ? 0 : checkbox.length
        var message = ''

        if(totals == 0) {
            Swal.fire({
                title: 'Kamu belum memilih kontak yang ingin dihapus!',
                icon: 'warning',
                position: 'bottom-end',
                timer: 1500
            })
        }else{


            $('#tbl-contact input[type=checkbox]:checked').each(function() {
                var row = $(this).val()
                array.push(row) 
            })
            //delete contact or update and set to deleted =  1
            $.ajax({
                url: url_api + '/contactsupplier/delete',
                type: 'post',
                data: {
                    id: array,
                    updatedby:users
                },
                success: function(res) {
                    $('#exampleModal').modal('hide')
                    Swal.fire(res.title, res.message, res.status)
                    if(res.status == 'success') show_tables($('#cari').val())
                }
            })
        }
    
    }
</script>
