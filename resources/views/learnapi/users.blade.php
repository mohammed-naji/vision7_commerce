<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <div class="container my-5">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>

            </tbody>

            {{-- @foreach ($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>
                        {{ $user['address']['city'] }}
                        <br>
                        {{ $user['address']['street'] }}
                        <br>
                        {{ $user['address']['suite'] }}
                    </td>
                    <td>{{ $user['phone'] }}</td>
                    <td>{{ $user['company']['name'] }}</td>
                </tr>
            @endforeach --}}
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script>
        $.ajax({
            url: 'https://jsonplaceholder.typicode.com/users',
            type: 'get',
            success: function(res) {

                res.forEach(user => {
                    let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        ${user.address.city}
                        <br>
                        ${user.address.street}
                        <br>
                        ${user.address.suite}
                    </td>
                    <td>${user.phone}</td>
                    <td>${user.company.name}</td>
                </tr>`;

                $('table tbody').append(row);
                });


                // console.log(res);
            }
        })
    </script>

  </body>
</html>
