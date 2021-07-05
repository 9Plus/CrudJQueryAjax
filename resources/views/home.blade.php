<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <style>
        .center {
            margin: auto;
            width: 80%;
            border: 3px solid green;
            padding: 10px;
            text-align: center;
        }

        body {
            background-color: black;
            color: white;
        }

        .post-create {
            float: right;
        }

    </style>
</head>

<body>
    <div class="center">
        <h1>Ajax jQuery</h1><br><br>
        <button type="button" class="btn btn-light m-2 post-create" id="add">Add Post</button>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th width="500px">Body</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>

    <div class="modal" style="color:black" tabindex="-1" id="create-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title">

                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" class="form-control" id="body" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" style="color:black" tabindex="-1" id="edit-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control edit-title" id="title">

                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" class="form-control edit-body" id="body" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit">Save</button>
                </div>
            </div>
        </div>
    </div>



    <<div class="modal" style="color:black" tabindex="-1" id="preview-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-preview">
                  
                    
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var $post = $('tbody');
            var $title = $("#title");
            var $body = $('#body');
            var $btncreate = $("#create");
            var $diaTitle = $(".edit-title");
            var $diaBody = $(".edit-body");
            var $editId = 0;
            var $btn;

            get_data();

            function get_data() {
                $.ajax({
                    type: "GET",
                    url: "/api/post",
                    success: function(data) {

                        $.each(data.post, function() {
                            $post.append(
                                '<tr data-id="' + this.id + '""><td>' +
                                this.id +
                                '</td><td class="title">' +
                                this.title +
                                '</td><td class="body">' +
                                this.body +
                                '</td><td>' +
                                '<button type="button"' +
                                ' class="btn btn-primary m-1 btn-preview" data-id="' + this.id + '">Preview</button>' +
                                '<button type="button" class="edit btn btn-success m-1" data-id="' +
                                this.id + '">Edit</button>' +
                                '<button type="button" data-id="' + this.id +
                                '" class="remove btn btn-danger m-1">Delete</button>' +
                                '</td></tr>'
                            )


                        });

                    }
                });
            }


            $btncreate.click(function() {
                var order = {
                    title: $title.val(),
                    body: $body.val()
                };
                $.ajax({
                    type: "POST",
                    url: "/api/post",
                    data: order,
                    success: function(data) {
                        $post.append(
                            "<tr><td>" +
                            data.post.id +
                            "</td><td>" +
                            data.post.title +
                            "</td><td>" +
                            data.post.body +
                            "</td><tr>"
                        );
                    },
                    error: function() {
                        console.log("error when post");
                    }

                })
            })

            $("#add").click(function() {
                $("#create-dialog").modal('show');
            })

            $post.delegate(".remove", 'click', function() {
                var $id = $(this).attr("data-id");
                var $tr = $(this).closest("tr");

                $.ajax({
                    type: "DELETE",
                    url: '/api/post/' + $id,
                    success: function() {
                        $tr.remove();
                    }
                })
            });

            $post.delegate(".edit", 'click', function() {
                $("#edit-dialog").modal('show');
                $btn = $(this).closest("tr");
                $id = $(this).attr("data-id");
                var $editTitle = $btn.find("td.title");
                var $editBody = $btn.find("td.body");


                $diaTitle.val($editTitle.text());
                $diaBody.val($editBody.text());

            });

            $("#edit").click(function() {
                var $record = {
                    title: $diaTitle.val(),
                    body: $diaBody.val(),
                };



                $.ajax({
                    type: "PUT",
                    url: "api/post/" + $id,
                    data: $record,
                    success: function(data) {
                        console.log(data);
                        $btn.find("td.title").text(data.post.title);
                        $btn.find("td.body").text(data.post.body);
                        $("#edit-dialog").modal('hide');

                    }
                })
            })
            $post.delegate('.btn-preview', 'click', function() {
                $("#preview-dialog").modal('show');
                $btn = $(this).closest("tr");
                $id = $(this).attr("data-id");
                var $editTitle = $btn.find("td.title");
                var $editBody = $btn.find("td.body");

                $('.body-preview').html(
                    '<p><b>Id </b>: '+$id+'</p>'+
                    '<p><b>Title </b>: '+$editTitle.text()+'</p>'+
                    '<p><b>Body </b>: '+$editBody.text()+'</p>'
                )
            })
        });
    </script>



</body>

</html>
