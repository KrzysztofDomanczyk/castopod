---
title: 更新
sidebarDepth: 3
---

# 如何更新 Castopod ？

安装 Castopod 后，你可能希望将实例更新到最新版本 版本以享受最新功能 ✨, 修复错误
🐛 和性能提升 ⚡。

## 更新说明

0. ⚠️ 在更新之前，我们强烈建议你备份 Castopod 文件和数据库。

   - 参看. [我应该在更新前进行备份吗？](#should-i-make-a-backup-before-updating)

1. 前往 [发布页面](https://code.castopod.org/adaures/castopod/-/releases) 和 查
   看您的实例是否是最新的 Castopod 版本

   - 参看
     [我在哪里可以找到我的 Castopod 版本？](#where-can-i-find-my-castopod-version)

2. 下载名为`Castopod Package`的最新发布包，你可以在 `zip` 或 `tar.gz` 压缩包之间
   选择

   - ⚠️ 请确保你下载的是 Castopod 软件包而 **不是** 源代码
   - 请注意，你还可以从 [castopod.org](https://castopod.org/)

3. 在你的服务器上：

   - 删除除 `.env` 文件和 `public/media` 目录之外的所有文件
   - 将下载软件包中的新文件复制到你的服务器中

     ::: 注意

     You may need to reset files permissions as during the install process.
     Check [Security Concerns](./security.md). 检查 [安全问题](./security.md)。

     :::

4. 从你的 `后台管理` > 更新你的数据库架构 `关于` 页或开始：

   ```bash
   php spark castopod:database-update
   ```

5. 从 `Castopod 管理页面` > `设置` > `通常` > `维护` 清理你的缓存
6. ✨ 享受你的新实例, 你已经更新完毕！

::: 注意

新版本可能有额外的更新说明(请参阅
[发布页面](https://code.castopod.org/adaures/castopod/-/releases))。

- cf.
  [我很长时间没有更新我的实例… 我该怎么办？](#我很长时间没有更新我的实例-我该怎么办)

:::

## 全自动更新

> 即将到来... 👀

## 常见问题（FAQ）

### 在哪里可以找到我的 Castopod 版本号？

跳转到你的 Castopod 管理面板，版本号显示在左下角。

或者，你可以在 `应用程序 > 配置 > Constants.php` 文件中找到版本号。

### 我很长时间没有更新我的实例… 我该怎么办？

没问题！ 只需如上所述获取最新版本。 No problem! Just get the latest release as
described above. Only, when going through the release instructions (4), perform
them sequentially, from the oldest to the newest.

> 你可能想要备份你的实例，这取决于您多久没有更新过 Castopod 。

例如，如果你在 `v1.0.0-alpha.42` 并想要升级到 `v1.0.0-beta.1`

0. (强烈推荐) 备份你的文件和数据库。

1. 下载最新版本，覆盖您的文件，同时保留 `.env` 文件和 `public/media` 文件夹。

2. 从 `v1.0.0-alpha.43` 开始，按顺序执行每个版本更新指令(从老版本到 最新版本)，
   然后是 `v1.0.0-alpha.44`，`v1.0.0-alpha.45`，…，直到 `v1.0.0-beta.1`。

3. ✨ 享受你的新实例, 你已经更新完毕！

### 我是否应该在更新前备份？

我们建议你这样做，这样就不会在出现任何问题时丢失数据！

更笼统地说，我们建议你定期备份您的 Castopod 文件和数据库，防止丢失所有内容……
