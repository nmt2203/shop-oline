<?php $user = $this->data["user"]; ?>
<img width="100%;" height="200px;" class="img-response" src="https://thumbs.dreamstime.com/b/no-user-profile-picture-24185395.jpg">
<h4 style="text-align: center;"><?php echo $user->name; ?></h4>
<ul class="list-group">
    <li class="list-group-item"><a href="/DoAnTH02/Account/index/"><span class="glyphicon glyphicon-info-sign"></span> General imformation </a></li>
    <li class="list-group-item"><a href="/DoAnTH02/Account/order_list/page=1/"><span class="glyphicon glyphicon-gift"></span> Order list</a></li>
    <li class="list-group-item"><a href="/DoAnTH02/Account/transaction_history/page=1/"><span class="glyphicon glyphicon-film"></span> Transaction history</a></li>
    <li class="list-group-item"><a href="/DoAnTH02/Account/comment_list/page=1/"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
    <li class="list-group-item"><a href="/DoAnTH02/Account/change_password"><span class="glyphicon glyphicon-lock"></span> Change password</a></li>
    <li class="list-group-item"><a href="/DoAnTH02/Home/do_logout/"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
</ul>