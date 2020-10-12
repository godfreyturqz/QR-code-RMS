//autofocus on login form
function autofocus(){
    $('#inputautofocus').focus()
}
var interval = setInterval(autofocus, 50)
//animations
$('.fadeIn').fadeIn(500)
$('.fadeIn-1').fadeIn(2000)
//alert
$('.alert').fadeOut(4000)
//navbar 
$('#sidebarCollapse').click(function(){
    $('#sidebar').toggle(250)
    $('#inputautofocus').focus()
})

//register
$('#regForm').submit(function(e){
    e.preventDefault()
    var regBtn = true
    var fname = $('#fname').val()
    var lname = $('#lname').val()
    var position = $("input[name='flexRadioDefault']:checked").val()
    var others = $('#others').val()
    var idnum = $('#idnum').val()
    var age = $('#age').val()
    var email = $('#email').val()
    var contact = $('#contact').val()
    var address = $('#address').val()
    $.post('includes/process.php', {
        regBtn: regBtn,
        fname: fname,
        lname: lname,
        position: position,
        others: others,
        idnum: idnum,
        age: age,
        email: email,
        contact: contact,
        address: address
    }, function(data){
        $('#data').html(data)
    })
    if (!fname){
        $('#fname').addClass('input-danger')
    }
    else{
        $('#fname').removeClass('input-danger')
    }
    if (!lname){
        $('#lname').addClass('input-danger')
    }
    else{
        $('#lname').removeClass('input-danger')
    }
    if (!idnum){
        $('#idnum').addClass('input-danger')
    }
    else{
        $('#idnum').removeClass('input-danger')
    }
    if (!age){
        $('#age').addClass('input-danger')
    }
    else{
        $('#age').removeClass('input-danger')
    }
    if (!email){
        $('#email').addClass('input-danger')
    }
    else{
        $('#email').removeClass('input-danger')
    }
    if (!contact){
        $('#contact').addClass('input-danger')
    }
    else{
        $('#contact').removeClass('input-danger')
    }
    if (!address){
        $('#address').addClass('input-danger')
    }
    else{
        $('#address').removeClass('input-danger')
    }
})
//settings- change username
$('#changeUsernameForm').submit(function(e){
    e.preventDefault()
    var changeUsernameBtn = true
    var currentUsername = $('#currentUsername').val()
    var newUsername = $('#newUsername').val()
    var pwd = $('#pwd').val()
    $.post('includes/process.php', {
        changeUsernameBtn: changeUsernameBtn,
        currentUsername: currentUsername,
        newUsername: newUsername,
        pwd: pwd
    }, function(data){
        $('#data').html(data)
    })
    if (!currentUsername){
        $('#currentUsername').addClass('input-danger')
    }
    else{
        $('#currentUsername').removeClass('input-danger')
    }
    if (!newUsername){
        $('#newUsername').addClass('input-danger')
    }
    else{
        $('#newUsername').removeClass('input-danger')
    }
    if (!pwd){
        $('#pwd').addClass('input-danger')
    }
    else{
        $('#pwd').removeClass('input-danger')
    }
})

//settings- change password
$('#changePasswordForm').submit(function(e){
    e.preventDefault()
    var changePasswordBtn = true
    var username = $('#username').val()
    var currentPwd = $('#currentPwd').val()
    var newPwd = $('#newPwd').val()
    var confirmNewPwd = $('#confirmNewPwd').val()
    $.post('includes/process.php', {
        changePasswordBtn: changePasswordBtn,
        username: username,
        currentPwd: currentPwd,
        newPwd: newPwd,
        confirmNewPwd: confirmNewPwd
    }, function(data){
        $('#data').html(data)
    })
    if (!username){
        $('#username').addClass('input-danger')
    }
    else{
        $('#username').removeClass('input-danger')
    }
    if (!currentPwd){
        $('#currentPwd').addClass('input-danger')
    }
    else{
        $('#currentPwd').removeClass('input-danger')
    }
    if (!newPwd){
        $('#newPwd').addClass('input-danger')
    }
    else{
        $('#newPwd').removeClass('input-danger')
    }
    if (!confirmNewPwd){
        $('#confirmNewPwd').addClass('input-danger')
    }
    else{
        $('#confirmNewPwd').removeClass('input-danger')
    }
})

//loginForm
$('#loginForm').submit(function(e){
    e.preventDefault()
    var loginVal = $('#inputautofocus').val()
    $.post('includes/modal.php', {
        loginBtn: loginVal
    }, function(data){
        $('#modal').html(data)
        clearInterval(interval)
        $("#loginModal").on('shown.bs.modal', function(){
            $('#inputTemp').focus()
        })
    })
})
//read btn
$('.readBtn').click(function(e){
    e.preventDefault()
    var id = $(this).attr('data-id')
    var itemNo = $(this).attr('data-itemNo')
    $.post('includes/modal.php', {
        readId: id,
        itemNo: itemNo
    }, function(data){
        $('#modal').html(data)
    })
})
//update btn
$('.updateBtn').click(function(e){
    e.preventDefault()
    var id = $(this).attr('data-id')
    var itemNo = $(this).attr('data-itemNo')
    var currentPage = $(this).attr('data-currentPage')
    var limitRecords = $(this).attr('data-limitRecords')
    $.post('includes/modal.php', {
        updateId: id,
        itemNo: itemNo,
        currentPage: currentPage,
        limitRecords: limitRecords
    }, function(data){
        $('#modal').html(data)
        $("#updateModal").on('shown.bs.modal', function(){
            $('#name').focus();
        })
    })
})
//delete btn
$('.deleteBtn').click(function(e){
    e.preventDefault()
    var id = $(this).attr('data-id')
    var itemNo = $(this).attr('data-itemNo')
    var currentPage = $(this).attr('data-currentPage')
    var limitRecords = $(this).attr('data-limitRecords')
    $.post('includes/modal.php', {
        deleteId: id,
        itemNo: itemNo,
        currentPage: currentPage,
        limitRecords: limitRecords
    }, function(data){
        $('#modal').html(data)
    })
})
//limit records
$('#limitRecords').change(function(){
    $('#limitRecordsForm').submit()
})
//display dashboard
// $('#limitRecords').change(function(){
//     $('#limitRecordsForm').submit()
// })
//live search
$('#search').keyup(function(){
    var searchVal = $(this).val()
    $.post('includes/process.php', {
        searchBtn: searchVal
    }, function(data){
        $('#tableBody').html(data)
    })
})
//search using enter
$('#searchForm').submit(function(e){
    e.preventDefault()
    var searchVal = $('#search').val()
    $.post('includes/process.php', {
        searchBtn: searchVal
    }, function(data){
        $('#tableBody').html(data)
    })
})
//sort
$('.columnSort').click(function(){
    var colName = $(this).attr("data-colName")
    var colOrder = $(this).attr("data-colOrder")
    var colArrow = ''
    if(colOrder == 'desc'){
        colArrow = '<i class="fa fa-long-arrow-up ml-2"></i>'
    }
    else{
        colArrow = '<i class="fa fa-long-arrow-down ml-2"></i>'
    }
    $.post('includes/process.php',{
        colName: colName,
        colOrder : colOrder
    }, function(data){
        $('#table').html(data) 
        $('[data-colName='+colName+']').append(colArrow)
    })
})


