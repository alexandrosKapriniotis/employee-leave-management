
# employee-leave-management

Employee leave management portal in PHP created as part of a pre employment assignment.

For the purpose of this assignment i followed the MVC application design pattern that separates the application data and business logic (model) from the presentation (view). I created my own MVC to showcase in my best knowledge my skills and my coding practises. 

The portal requires for an authorisation keeping the registration hidden and managed only by user admins.





## API Reference

#### Portal login

`
  GET /login/
`

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. Your users email |
| `password` | `string` | **Required**. Your users password |

#### Logout

`
  GET /logout
`

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
|     |  | |

#### User Index (protected route : requires user type admin)
`
  GET /users
`
#### User creation page (protected route : requires user type admin)
`
  GET /users/new
`

#### User creation endpoint (protected route : requires user type admin)
`
  POST /users/new
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `first_name`   | `string` | **Required**. User first name |
| `last_name`   | `string` | **Required**. User last name |
| `email`       | `string` | **Required**. User email |
| `user_type`   | `string` | **Required**. User type (employee, admin) |
| `password` | `string` | **Required**. User password (must match the password below) |
| `confirmPassword` | `string` | **Required**. Confirm your user password (must match the password above) |

#### Get user information page (protected route : requires user type admin)
`
  GET /users/{id:\d+}
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. User id |

#### Get user edit page (protected route : requires user type admin)
`
  GET /users/{id:\d+}/edit
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. User id |

#### Delete user (protected route : requires user type admin)
`
  POST /users/{id:\d+}/delete
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. User id |

#### Application Index 
`
  GET /applications
`
#### Application creation page
`
  GET /applications/new
`
#### Application creation endpoint
`
  POST /applications/new
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `date_from`   | `date` | **Required**. Vacation start |
| `date_to`     | `date` | **Required**. Vacation end |
| `reason`       | `string` | **Required**. Vacation reason |

#### Approve application (protected route : requires user type admin)
`
  POST /applications/{id:\d+}/status/{status:approved}
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Application id |

#### Reject application (protected route : requires user type admin)
`
  POST /applications/{id:\d+}/status/{status:rejected}
`
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Application id |


