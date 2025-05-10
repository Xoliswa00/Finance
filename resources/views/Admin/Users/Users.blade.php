@extends('layouts.Admin')
@section('content')
<div class="container-fluid py-4">
     
        <div class="col-auto">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Users Management</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table  table-responsive table-hover align-items-center mb-0">
                  <thead class="">
                    <tr class="bg-gradient-dark ">
                      <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Full Name</th>
                      <th class="text-uppercase   text-white text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                      <th class="text-center   text-uppercase text-white text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center   text-uppercase text-white text-xxs font-weight-bolder opacity-7">Joined</th>
                      <th class="text-secondary opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($friends as $users)
                    <tr id="userRow_{{ $users->id }}">
                        <!-- Existing HTML content for each user -->
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div>
                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $users->name }} {{ $users->Surname }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $users->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $users->Role }}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success" id="lastSeen_{{ $users->id }}">{{ $users->last_seen }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $users->created_at }}</span>
                        </td>
                      <td class="align-middle navbar-nav navbar-nav-hover ms-auto">
                        <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-2">
                            <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center" id="dropdownMenuPages5" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                              Actions
                              <img src="../../assets/img/down-arrow-dark.svg" alt="down-arrow" class="arrow ms-auto ms-md-2">
                            </a>
                            <div class="dropdown-menu ms-n3 dropdown-menu-animation dropdown-sm p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages5">
                              <div class="d-none d-lg-block">
                                <a href="../../pages/about-us.html" class="dropdown-item border-radius-md">
                                    <span>Deactivity Users</span>
                                  </a>
                                <a href="../../pages/about-us.html" class="dropdown-item border-radius-md">
                                  <span>Modify user</span>
                                </a>
                                <a href="../../pages/contact-us.html" class="dropdown-item border-radius-md">
                                  <span>User Activity</span>
                                </a>
                                
                              </div>
                             
                            </div>
                          </li>
                      
                      </td>
                    </tr>
                    @endforeach
                <!--- 
                     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        //sectioned out for now as it doesnt increase productvity but server activity
                        function updateOnlineUsers() {
                            console.log('Updating online users...');
                            $.get('/online-users', function(response) {
                                console.log('Response:', response);
                                var onlineUsers = response.online_users;
                        
                                onlineUsers.forEach(function(user) {
                                    // Update last seen for each user
                                    console.log('Updating last seen for user', user.id, 'to', user.last_seen);
                                    $('#lastSeen_' + user.id).text(user.last_seen);
                                });
                            });
                        }
                        
                        // Call the function initially and every 1 minute (adjust as needed)
                        updateOnlineUsers();
                        setInterval(updateOnlineUsers, 60000);
                        </script>
                    -->  
                        
                  
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>


          


        </div>
      </div>
@if(isset($admins))
      <div class="col-auto">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Admin Management</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table  table-responsive table-hover align-items-center mb-0">
                <thead class="">
                  <tr class="bg-gradient-dark ">
                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Full Name</th>
                    <th class="text-uppercase   text-white text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                    <th class="text-center   text-uppercase text-white text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center   text-uppercase text-white text-xxs font-weight-bolder opacity-7">Joined</th>
                    <th class="text-secondary opacity-7">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($admins as $users)
                  <tr id="userRow_{{ $users->id }}">
                      <!-- Existing HTML content for each user -->
                      <td>
                          <div class="d-flex px-2 py-1">
                              <div>
                                  <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                              </div>
                              <div class="d-flex flex-column justify-content-center">
                                  <h6 class="mb-0 text-sm">{{ $users->name }} {{ $users->Surname }}</h6>
                                  <p class="text-xs text-secondary mb-0">{{ $users->email }}</p>
                              </div>
                          </div>
                      </td>
                      <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $users->Role }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm bg-gradient-success" id="lastSeen_{{ $users->id }}">{{ $users->last_seen }}</span>
                      </td>
                      <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold">{{ $users->created_at }}</span>
                      </td>
                    <td class="align-middle navbar-nav navbar-nav-hover ms-auto">
                        <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-2">
                            <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center" id="dropdownMenuPages5" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                              Actions
                              <img src="../../assets/img/down-arrow-dark.svg" alt="down-arrow" class="arrow ms-auto ms-md-2">
                            </a>
                            <div class="dropdown-menu ms-n3 dropdown-menu-animation dropdown-sm p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages5">
                              <div class="d-none d-lg-block">
                                <a href="../../pages/about-us.html" class="dropdown-item border-radius-md">
                                    <span>Deactivity Users</span>
                                  </a>
                                <a href="../../pages/about-us.html" class="dropdown-item border-radius-md">
                                  <span>Modify user</span>
                                </a>
                                <a href="../../pages/contact-us.html" class="dropdown-item border-radius-md">
                                  <span>User Activity</span>
                                </a>
                                <a href="../../pages/contact-us.html" class="dropdown-item border-radius-md">
                                    <span>Assign Admin</span>
                                  </a>
                                
                              </div>
                             
                            </div>
                          </li>
                    
                    
                    </td>
                  </tr>
                  @endforeach
     
                      
                
                
                </tbody>
              </table>
            </div>
          </div>
        </div>


        


      </div>
    </div>
    @endif
  
    
      

@endsection