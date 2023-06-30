@extends('layouts.app')

@section('content')
<div class="modal fade" id="updateActivity" tabindex="-1" aria-labelledby="updateActivityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('activity.update',0) }}" method="POST">
        {{-- <div class="modal-header">
          <h5 class="modal-title" id="updateActivityLabel">New message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> --}}
        <div class="modal-body">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="activity-name" class="col-form-label">Activity:</label>
              <input type="text" class="form-control" id="activity-name" disabled>
            </div>
            <div class="mb-3">
              <label for="activity-comment" class="col-form-label">Spill your story:</label>
              <textarea class="form-control" name="comment" id="activity-comment"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="status" value="Done">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Mark As Done</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-12  mt-3">
          <div class="h2">Recent activity around you</div>
        </div>
        @foreach ($FeedPosts as $FeedPost)

        <div class="col-sm-12 mb-3">
          <div class="card">
            <div class="card-header row">
              <div class="col-md-9 fw-bold">{{ $FeedPost->username }}</div>
              <div class="col-md-3 text-end">{{ $FeedPost->doneby }}</div>            
            </div>
              <div class="card-body">
                <h5 class="card-title">{{ $FeedPost->comment }}</h5>
                <p class="card-text">
                    Activity done: {{ $FeedPost->Activity['activity'] }}
                </p>
              </div>
            </div>
        </div>       
        @endforeach   
      </div>
    </div>
    <div class="col-md-4">
      <div class="row ">
        <div class="col-sm-12  mt-3">
          <div class="h2">Do your saved activities</div>
        </div>
        <div class="col-sm-12">
          <div class="card">
            <ul class="list-group list-group-flush">
              @foreach ($SavedActivities as $SavedActivity)
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-sm-10">{{ $SavedActivity-> Activity['activity'] }}</div>
                    <div class="col-sm-2 px-0">
                      <form action="{{ route('activity.destroy',$SavedActivity->id) }}" method="POST">   
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                          <button type="button" class="btn btn-outline-success px-1" data-bs-toggle="modal" data-bs-target="#updateActivity" 
                          data-bs-activity="{{ $SavedActivity-> Activity['activity'] }}"
                          data-bs-id="{{ $SavedActivity-> id }}"
                          ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                          </svg></button>
                          @csrf
                          @method('DELETE')            
                          <button type="submit" class="btn btn-outline-danger px-1" onclick="return confirm('Are you sure to remove {{ $SavedActivity-> Activity['activity'] }} from your activity list?');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                          </svg></button>
                        </div>
                      </form>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


<script>
  document.addEventListener("DOMContentLoaded", () => {
    var updateActivity = document.getElementById('updateActivity')
    updateActivity.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var user = button.getAttribute('data-bs-user')
      var activity = button.getAttribute('data-bs-activity')
      var id = button.getAttribute('data-bs-id')
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      // updateActivity.querySelector('.modal-title').textContent = 'New message to ' + activity
      updateActivity.querySelector('#activity-name').value = activity
      updateActivity.querySelector('#activity-comment').value = ""
      updateActivity.querySelector('form').action = "{{ route('activity.update',0) }}".replace('activity/0','activity/'+ id);
    })
  });
</script>