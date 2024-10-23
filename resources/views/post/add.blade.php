<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Post</title>
  </head>
  <body>
    <h1>Post</h1>

    <form id="post" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" name="date" id="date">
      </div>

      <div class="form-group">
        <label for="author">Author</label>
        <textarea class="form-control" name="author" id="author" rows="3"></textarea>
      </div>

      <div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" name="content" id="content"></textarea>
  </div>
      
      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" name="image" id="image">
      </div>
      
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery (full version) first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-fQybjgWLrvvRgtW6K0i32kf5mK9Y9+Az95A2A4/5PQQzxnPRQKNL5dh5m5q/sFY5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
      $('#post').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
          method: 'POST',
          url: '{{ route("posts.store") }}',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            alert(response.success);
            alert('Post saved successfully');
            window.location.href = '/posts'; // Redirect after success
          },
          error: function(xhr, status, error) {
            let err = JSON.parse(xhr.responseText);
            console.log(err.message);
            alert('Something went wrong. Please try again.');
          }
        });
      });
    </script>
  </body>
</html>
