<?php

use Illuminate\Database\Seeder;

class AuthenticateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Authenticate (Admin, Employee, User)
        echo "Authentication seeding .... \n";
    	App\Admin::create([
        	'name'=>'Admin',
        	'email'=>'admin@admin.com',
        	'password'=>bcrypt('secret'),
        ]);
        App\Admin::create([
            'name'=>'Hasan-admin',
            'email'=>'hasan@admin.com',
            'password'=>bcrypt('secret'),
        ]);
        App\User::create([
        	'name'=>'User',
        	'email'=>'hasan@user.com',
        	'password'=>bcrypt('secret'),
        ]);
        App\Employee::create([
        	'name'=>'Employee',
        	'email'=>'employee@employee.com',
            'created_by'=>1,
        	'password'=>bcrypt('secret'),
        ]);
        App\Employee::create([
            'name'=>'Hasan-employee',
            'email'=>'hasan@employee.com',
            'created_by'=>1,
            'password'=>bcrypt('secret'),
        ]);
        App\Admin::create([
        	'name'=>'Hasan',
        	'email'=>'hasan@dev.com',
        	'password'=>bcrypt(123456),
        ]);
        App\Employee::create([
            'name'=>'Hasan-employee',
            'email'=>'hasan@dev.com',
            'created_by'=>1,
            'password'=>bcrypt(123456),
        ]);

        $employees = App\Employee::all();
        foreach ($employees as $employee) {            
            App\EmployeeDetail::create([
                'employee_id'=>$employee->id,
                'full_name'=>$employee->name,
                'phone'=>'01800000000',
                'bitbucket'=>$employee->email,
                'trello'=>$employee->email,
                'skype'=>$employee->email,
                'avatar'=>'default/images/1.jpg',
                'designation'=>'employee',
                'join_date'=>"2019-06-01",
                'address'=>'',
            ]);
        echo "Employee Detail seeded\n";
        }
        echo "Admin: email: admin@admin.com, password: secret\n";
        echo "Employee: email: employee@employee.com, password: secret\n";
        echo "Authentication seeded .... \n";
    }
}
