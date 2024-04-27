<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    protected $json = '
    {
        "departments": [
          {
            "name": "Engineering",
            "users": [
              {
                "name": "John Doe",
                "birthdate": "1990-05-15",
                "nit": "123456789",
                "contact": {
                  "email": "john.doe@example.com",
                  "phone": "+1234567890",
                  "address": "123 Main St, City"
                },
                "permissions": ["read", "write"]
              },
              {
                "name": "Jane Smith",
                "birthdate": "1985-08-22",
                "nit": "987654321",
                "contact": {
                  "email": "jane.smith@example.com",
                  "phone": "+1234567891",
                  "address": "456 Oak St, City"
                },
                "permissions": ["read"]
              }
            ]
          },
          {
            "name": "HR",
            "users": [
              {
                "name": "Alice Johnson",
                "birthdate": "1995-02-10",
                "nit": "456789123",
                "contact": {
                  "email": "alice.johnson@example.com",
                  "phone": "+1234567892",
                  "address": "789 Elm St, City"
                },
                "permissions": ["read", "write", "delete"]
              }
            ]
          }
        ]
      }
      ';


    public function process()
    {
        // Json converted into an Array
        $data = json_decode($this->json, true);
        info($data);

        $result = [];

        /* Start of example on access to element (you can remove it)

        $firstDeparmentUsers= $data['departments'][0]['users'];
        $firstUserName= $firstDeparmentUsers[0]['name'];

        End of example */

        // Write your code here
      
        for ($i=0; $i < count($data["departments"]); $i++) { 
          $users = $data["departments"][$i]["users"];
          foreach ($users as $user) {
            if (!$this->emailKeyExists($user["contact"])) {
              continue;
            }

            if ($this->emailExists($user["contact"]["email"])) {
              continue;
            }

            $this->createUser(
              $user["name"] ?? null,
              $user["birthdate"], 
              $user["nit"] ?? null, 
              $user["contact"]["email"]
            );
          }
        }

        // use $this->createUser(...) to save the user in the database


        // End of your code

        $allUsers = User::get();

        // Transform each user into a UserResource
        $formattedUsers = $allUsers->map(function ($user) {
          return $user->UserResource();
        });

        return $formattedUsers;
    }

    private function emailKeyExists($user) {
      if (!array_key_exists('email', $user)) {
        error_log("Contact email not found");
        return false;
      }
      return true;
    }

    private function emailExists($email) {
      if (User::where('email', $email)->exists()) {
        error_log("Email already exists");
        return true;
      }
      return false;
    }

    protected function createUser($name, $birthdate, $nit, $email)
    {
        $user = [
            'name' => $name,
            'birthdate' => $birthdate,
            'nit' => $nit,
            'email' => $email,
        ];

        User::create($user);

        return $user;
    }
}
