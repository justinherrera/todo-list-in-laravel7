console.log("Hello Worlds")
  $('.badge').text($('tr').length)
  var old_id = 0;
  var time = 0;
  var latest_id = 0;
  $(document).on('click', '#edit', function(){
      console.log($(this).data('id'))
    let todo_id = $(this).data('id');
    let todo_name = $(this).data('name');
    let todo_time = $(".time-"+todo_id).text();
    console.log(todo_time)
    time = todo_time
    old_id = todo_id;
    //$('#client-id').val(client_id);
    $('#todo_id').val(todo_id);
    $('.todo_name').val(todo_name);
    //$(this).attr("data-target","#myModal");
    $('#myModal').modal();
  });

  $(document).on('click', '.status', function(){
    console.log( $(this).data('id') )
    if($(this).text() == "Pending..."){
        $(this).removeClass("btn btn-info status");
        $(this).addClass("btn btn-success status");  
        $(this).text('Completed');  
    }else{
        $(this).removeClass("btn btn-success status");
        $(this).addClass("btn btn-info status");  
        $(this).text('Pending...');          
    }
  });

  $(document).on('click', '.clear', function(){
    $('.todo_name_field').val("")
  })

  // Delete Data
  $(document).on('click', '.delete', function(e){
    var data_id = $('#edit').data('id')
    e.preventDefault();
    e.target.parentNode.parentNode.parentNode.outerHTML = ""
    $.ajax({
        url: "todos/"+data_id,
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            _method: "DELETE"
        },
        success: function(response){
           // $(this).parents('.row-'+$(this).data('id')).fadeOut('slow', function() { $(this).remove(); })
        }
    })

  })

  // Update Data
  $(document).on('submit', '#form-data', function(e){
    e.preventDefault();

    let id = $(".todo_id").val();
    if(old_id == 0 || old_id == "0") old_id = old_id + 1
    console.log(old_id)

    $.ajax({
        type: "PUT",
        url: "/todos/"+old_id,
        data: $("#form-data").serialize(),
        success: function(reponse){
            $(".save").modal("hide");
            window.location.reload();
        },
        error: function(error){
            console.log(error)
        }
    })
  });

  $(document).on('submit', '#addForm', function(e){
    e.preventDefault();
    let todo_name = $("input[name=todo_name]").val();
    let todo_id = $("#edit").attr('data-id');

    let postData = {
        id: todo_id,
        name: todo_name
    }
    if(time == 0 || time == "0"){
        time = "few seconds ago"
    }

    if(old_id == 0 || old_id == "0") old_id = old_id + 1
    //console.log(lastID)
    $.ajax({
        type: "POST",
        url: "/todos",
        data: $("#addForm").serialize(),
        success: function(response){
            latest_id = response.last_insert_id
            alert('New Task Added')
            var tr_str =  `<tr class = "row-"`+latest_id+`>
            <td>`+todo_name+`</td>
            <td>`+time+`</td>
            <td><button class="btn btn-info status" data-id="`+latest_id+`" type="button">Pending...</button></td>
            <td>
            <a id = "edit" href="" data-id="`+latest_id+`" data-name="`+todo_name+`" class="btn btn-primary" data-toggle="modal">Edit</a>
            </td>
            <td>
                <form action="{{ route('todos.destroy', $todo->id)}}" method="post">
                  <button class="btn btn-danger delete" type="submit">Delete</button>
                </form>
            </td>
            
            </tr>`;
            $('tbody').append(tr_str);
            
        },
        error: function(error){
            console.log(error)
        }
    })
  });
