var LoginBean=function(){this.initQuery=function(){$("#tabs").tabs()}};LoginBean.instance=null;LoginBean.getInstance=function(){if(LoginBean.intance==null){LoginBean.instance=new LoginBean()}return LoginBean.instance};