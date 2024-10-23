<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Posts List</title>
</head>
<body>
<div class="container mt-5">
    <h1>Posts List</h1>
    <a href="{{ route('posts.add') }}" class="btn btn-primary mb-3">Create New Post</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Date</th>
                <th>Content</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->author }}</td>
                    <td>{{ $post->date }}</td>
                    <td>{{ Str::limit($post->content, 50) }}</td>
                    <td>
                        @if($post->image)
                            <img src="{{ asset('images/' . $post->image) }}" alt="Post Image" width="50">
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning" onclick="editPost({{ $post->id }})">Edit</button>
                        <button class="btn btn-danger" onclick="deletePost({{ $post->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Post Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="postForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Use PUT for updating -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <textarea class="form-control" name="author" id="author" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img id="imagePreview" src="" alt="Image Preview" style="display: none; width: 100px;">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to delete a post
    function deletePost(id) {
        if (confirm('Are you sure you want to delete this post?')) {
            $.ajax({
                type: 'DELETE',
                url: `/posts/${id}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.success);
                    window.location.reload();  // Reload page after deletion
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }

    // Function to edit a post
    function editPost(id) {
        $.get(`/posts/${id}/edit`, function(data) {
            $('#name').val(data.name);
            $('#date').val(data.date);
            $('#author').val(data.author);
            $('#content').val(data.content);
            $('#imagePreview').attr('src', `/storage/${data.image}`).show();
            $('#postForm').attr('action', `/posts/${id}`).attr('data-id', id);
            $('#postModal').modal('show');
        });
    }

    // Handle the form submission for editing the post
    $('#postForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        let formData = new FormData(this);
        let id = $(this).attr('data-id'); // Get the ID from the form's data-id attribute

        $.ajax({
            type: 'POST',
            url: `/posts/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                window.location.reload(); // Reload page after update
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error updating post: ' + xhr.responseText);
            }
        });
    });
</script>
</body>
</html>
