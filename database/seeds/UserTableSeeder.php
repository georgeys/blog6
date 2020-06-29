<?php

use Illuminate\Database\Seeder;
Use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = factory(User::class)->times(50)->make();
        User::insert($user->makeVisible(['password','remember_token'])->toArray());
        $user = User::find(1);
        $user->name = 'yuan';
        $user->email = '1342479179@qq.com';
        $user->password = bcrypt('111111');
        $user->save();
    }
    //times 和 make 方法是由 FactoryBuilder 类 提供的 API。times 接受一个参数用于指定要创建的模型数量，make 方法调用后将为模型创建一个 集合。
    //makeVisible 方法临时显示 User 模型里指定的隐藏属性 $hidden，接着我们使用了
    // insert 方法来将生成假用户列表数据批量插入到数据库中。
    //最后我们还对第一位用户的信息进行了更新，方便后面我们使用此账号登录。
    //
    //接着我们还需要在 DatabaseSeeder 中调用 call 方法来指定我们要运行假数据填充的文件。
    //
    //database/seeds/DatabaseSeeder.php
}
