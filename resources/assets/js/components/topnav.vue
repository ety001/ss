<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="header">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <router-link tag="li" to="/" exact active-class="active">
                            <a>首页</a>
                        </router-link>
                        <router-link tag="li" to="/login" active-class="active">
                            <a>登录</a>
                        </router-link>
                        <router-link tag="li" to="/regin" active-class="active">
                            <a>注册</a>
                        </router-link>
                    </ul>
                </nav>
                <h3 class="text-muted"><a href="/">SS</a></h3>
            </div>
        </div>
    </div>
</template>
