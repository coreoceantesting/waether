@if (session('status'))
   <div class="alert alert-success alert-dismissible" role="alert">
      <a href="javascript::void(0)" style="text-decoration: none" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{ session('status') }}
   </div>
@endif