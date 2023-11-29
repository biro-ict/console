<?php $user = isset($_GET['user']) ? $_GET['user'] : ''; $year = Date('Y');?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-title text-white">Data Budget Tahun <span id="year_text"><?php echo $year;?></span></h4>

                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select form-select-sm" id="budget-area">
                                <option>--PILIH AREA--</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select id="budget-dept" class="form-select form-select-sm">
                                <option>--PILIH DEPARTEMEN--</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select id="budget-head" class="form-select form-select-sm">
                                <option>--PILIH ANGGARAN--</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select id="budget-year" class="form-select form-select-sm">
                                <option>--PILIH TAHUN--</option>
                            </select>
                        </div>
                        <div class="col-auto"><button type="button" class="btn btn-sm btn-primary" id="search_budget">CARI</button></div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="height:400px;">
                                <table class="table table-sm table-striped table-hover caption-top">
                                    <caption style="color:black;">Jumlah Anggaran vs Realisasi budget: 
                                        <span id="sum_anggaran">0</span> vs <span id="sum_real">0</span>
                                    </caption>
                                    <thead>
                                        <th class="col">#</th>
                                        <th class="col">Area</th>
                                        <th class="col">DeptCode</th>
                                        <th class="col">Departemen</th>
                                        <th class="col">MataAnggaran </th>
                                        <th class="col">Ikhtisar</th>
                                        <th class="col">Bulan</th>
                                        <th class="col">Anggaran</th>
                                        <th class="col">Realisasi</th>
                                    </thead>
                                    <tbody id="tbl-budget">
                                        <tr>
                                            <td colspan="9" class="text-center">Data will available in here</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-primary" id="edit_data">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" id="backto">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function list_area() {
        //isi untuk list area

        $.ajax({
            url: url_api + '/budgets/area',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    res.data.forEach(function(items, area) {
                        opt = opt + `<option value="${items.AreaCode}">${items.AreaName}</option>`;
                    })

                    $('#budget-area').html(opt)
                }
            }
        })
    }

    function list_dept() {
        //isi untuk list dept
        $.ajax({
            url: url_api + '/budgets/depts',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    res.data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.DeptID}">${items.department}</option>`;
                    })

                    $('#budget-dept').html(opt)
                }
            }
        })
    }

    function list_budget_header(){
        $.ajax({
            url: url_api + '/budgets/header',
            type: 'get',
            success: function(res) {
                var opt = ''
                if(res.status == 'success') {
                    res.data.forEach(function(items, index) {
                        opt = opt + `<option value="${items.MataAnggaran}">${items.MataAnggaran} (${items.Ikhtisar})</option>`
                    })

                    $('#budget-head').html(opt)
                }
            }
        })
    }

    function list_tahun() {
        //isi untuk list tahun 
        $.ajax({
            url: url_api + '/budgets/years',
            type: 'get',
            success: function(res) {
                if(res.status == 'success') {
                    var opt = ''
                    var currYear = new Date().getFullYear()
                    var nextYear = currYear + 1;
                    res.data.forEach(function(items, index) {
                        var selected = items.Tahun == currYear ? 'selected' : '';
                        opt = opt + `<option value="${items.Tahun}" ${selected}>${items.Tahun}</option>`
                    })

                    opt = opt + `<option value="${nextYear}">${nextYear}</option>`

                    $('#budget-year').html(opt)
                }
            }
        })
    }

    function show_field() {
        $('#edit_data').css('display', 'none')
        var area = $('#budget-area').val()
        var dept = $('#budget-dept').val()
        var head = $('#budget-head').val()
        var year = $('#budget-year').val()
       
        $.ajax({
            url: url_api + '/budgets/detail',
            type: 'post',
            data: {
                area: area,
                dept: dept,
                head: head,
                year: year
            },
            success: function(res) {
                var tbody = ''
                if(res.status == 'success') {
                    $('#sum_anggaran').html(res.total[0].total_anggaran)
                    $('#sum_real').html(res.total[0].total_real)
                    var data = res.data

                    //data stored full 
                    if(data.length == 12) {
                        for(i=0; i < data.length; i++){
                            tbody = tbody + `
                                <tr>
                                    <td><small>${i+1}</small></td>
                                    <td><small>${data[i].AreaCode}</small></td>
                                    <td><small>${data[i].DeptID}</small></td>
                                    <td class="text-small">${data[i].DeptName}</td>
                                    <td class="text-small">${data[i].MataAnggaran}</td>
                                    <td class="text-small">${data[i].Ikhtisar}</td>
                                    <td class="text-small">${data[i].Bulan}</td>
                                    <td>
                                    <input type="hidden" name="bulan[]" value="${data[i].Bulan}">
                                    <input type="number" name="anggaran[]" class="form-control form-control-sm" value="${data[i].Anggaran}"></td>
                                    <td class="text-small">${data[i].Realisasi}</td>
                                </tr>`
                        }
                    }else{
                        var sisabulan = 12 - data.length

                        //data stored not full
                        for(i=0; i < data.length; i++){
                          
                            tbody = tbody + `
                                <tr>
                                    <td><small>${i+1}</small></td>
                                    <td><small>${data[i].AreaCode}</small></td>
                                    <td><small></small>${data[i].DeptID}</td>
                                    <td class="text-small">${data[i].DeptName}</td>
                                    <td class="text-small">${data[i].MataAnggaran}</td>
                                    <td class="text-small">${data[i].Ikhtisar}</td>
                                    <td class="text-small">${data[i].Bulan}</td>
                                    <td>
                                    <input type="hidden" name="bulan[]" value="${data[i].Bulan}">
                                    <input type="number" class="form-control form-control-sm" name="anggaran[]" value="${data[i].Anggaran}"></td>
                                    <td class="text-small">${data[i].Realisasi}</td>
                                </tr>`
                        }
                        for(i=i; i < (sisabulan+1); i++) {
                            var bulan = (i+1) < 10 ? "0"+(i+1) : (i+1)
                            tbody = tbody + `
                                <tr>
                                    <td><small>${i+1}</small></td>
                                    <td><small>${area}</small></td>
                                    <td><small>${dept}</small></td>
                                    <td class="text-small">${res.data2[0].deptName}</td>
                                    <td class="text-small">${head}</td>
                                    <td class="text-small">${res.data2[0].Ikhtisar}</td>
                                    <td class="text-small">${bulan}</td>
                                    <td>
                                    <input type="hidden" name="bulan[]" value="${bulan}">
                                    <input type="number" name="anggaran[]" class="form-control form-control-sm" value="0"></td>
                                    <td class="text-small">0</td>

                                </tr>`
                        }
                    }
                    
                }else{

                    //data empty
                    for(i=0; i < 12; i++){
                        var bulan = (i+1) < 10 ? "0"+(i+1) : (i+1)
                            tbody = tbody + `
                                <tr>
                                    <td><small>${i+1}</small></td>
                                    <td><small>${area}</small></td>
                                    <td><small>${dept}</small></td>
                                    <td class="text-small">${res.data2[0].deptName}</td>
                                    <td class="text-small">${head}</td>
                                    <td class="text-small">${res.data2[0].Ikhtisar}</td>
                                    <td class="text-small">${bulan}</td>
                                    <td>
                                    <input type="hidden" name="bulan[]" value="${bulan}">
                                    <input type="number"  name="anggaran[]" class="form-control form-control-sm" value="0"></td>
                                    <td class="text-small">0</td>

                                </tr>`
                    }
                }
                
                

                tbody = tbody + `<tr><td colspan="8"></td><td><button type="button" onclick="simpan_data('${area}', '${dept}', '${head}', '${year}')" class="btn btn-primary btn-sm">Simpan</button></td></tr>`
                $('#tbl-budget').html(tbody)

            }
        })
        
    }

    function simpan_data(area, dept, head, year){
        var bulan = document.getElementsByName('bulan[]')
        var anggaran = document.getElementsByName('anggaran[]')
        var arrBulan = [];
        var arrAnggaran = []
        for(i=0; i < bulan.length; i++){
           arrBulan.push(bulan[i].value)
           arrAnggaran.push(anggaran[i].value)
        }
        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Data budget akan diubah',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ubah',
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url_api + '/budgets/update',
                    type: 'post',
                    data: {
                        area: area,
                        dept: dept,
                        mataanggaran: head,
                        tahun: year,
                        bulan: arrBulan,
                        anggaran: arrAnggaran
                    },
                    success: function(res) {
                        swal.fire(res.title, res.message, res.status)
                        show_tables()
                    }
                })
            }else{
                Swal.fire('Batal', 'Batal mengubah data', 'error')
                show_tables();
            }
        })
    }

    function show_tables() {
        //isi untuk lihat data table
        var area = $('#budget-area').val()
        var dept = $('#budget-dept').val()
        var head = $('#budget-head').val()
        var year = $('#budget-year').val()

        $.ajax({
            url: url_api  + '/budgets/detail',
            type: 'post',
            data: {
                area: area,
                dept: dept,
                head: head,
                year: year
            },
            success: function(res) {
                var tbody = ''
                if(res.status == 'success') {
                    $('#sum_anggaran').html(res.total[0].total_anggaran)
                    $('#sum_real').html(res.total[0].total_real)
                    var data = res.data
                    for(i=0; i < data.length; i++){
                        tbody = tbody + `
                            <tr>
                                <td><small>${i+1}</small></td>
                                <td><small>${data[i].AreaCode}</small></td>
                                <td><small>${data[i].DeptID}</small></td>
                                <td class="text-small">${data[i].DeptName}</td>
                                <td class="text-small">${data[i].MataAnggaran}</td>
                                <td class="text-small">${data[i].Ikhtisar}</td>
                                <td class="text-small">${data[i].Bulan}</td>
                                <td class="text-small">${data[i].Anggaran}</td>
                                <td class="text-small">${data[i].Realisasi}</td>

                            </tr>`
                    }
                }else{
                    tbody = `<tr> <td colspan="9" class="text-center">Sorry, nothing found</td></tr>`
                }

                $('#tbl-budget').html(tbody)
                var currYear = new Date().getFullYear();
                if($('#budget-year').val() >= currYear){
                
                    var user = `<?php echo $user;?>`;
                    var validatedUser = ['diki.nugraha', 'ahmad.damasanto', 'firman']
                    if(validatedUser.includes(user)) {
                        $('#edit_data').css('display', 'inline')
                    }
                }else{
                    $('#edit_data').css('display', 'none')
                }
            }
        })
    }
    
    $('#edit_data').on('click', function() {
        show_field()
    })

    $('#search_budget').on('click', function() {
        show_tables()
    })

    $('#backto').on('click', function() {
        show_tables()
    })

    $(document).ready(function() {
      
        $('#edit_data').css('display', 'none')
        list_area()
        list_dept()
        list_budget_header()
        list_tahun()
    })
</script>