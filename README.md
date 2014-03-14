PServer
=======

- tcenterd 中心服务进程

	使用thrift远程调用实现的http服务器。
	此进程启动多组， 并用硬件或者代理服务器做负载平衡， 具有宕机重启功能。
	用来实现全局的操作，比如登录, 网站对接, 分配scene等。

- smanager 场景管理进程

	每个smanager对应一台主机， 用来管理主机上所运行的scened进程。
	一般用来处理公共数据， 执行数据库操作， 与centerd通信等。

- scened 场景进程

	每个scened进程对应一个cpu计算单元， 处理游戏的实时信息。
