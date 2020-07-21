# 工作流

1、定义model.yaml
```yaml 
models:
  Goods:
    name: string:40 default:'' comment:'商品名'
    desc: longtext nullable comment:'描述内容'
    cate_id: unsignedinteger default:'0' comment:'分类id'
    first_cate_id: unsignedinteger default:'0' comment:'一级分类id'
    type_id: unsignedtinyinteger default:'0' comment:'商品类型id'
    is_sale: unsignedtinyinteger default:'2' comment:'上架状态1上架2下架'
    goods_top: unsignedtinyinteger default:'2' comment:'状态1置顶2非置顶'
    goods_recommend: unsignedtinyinteger default:'2' comment:'状态1推荐2非推荐'
    goods_new: unsignedtinyinteger default:'2' comment:'状态1新品2非新品'
    sort: unsignedtinyinteger default:'100' comment:'排序越小越在前'
    published_at: timestamp nullable comment:'发布时间'
    softDeletes

seeders: Goods

```

2、运行命令
```
php artisan blueprint:build demo_blueprint\goods_model.yaml
```

3、生成测试数据
```
php artisan tinker

factory(App\Models\Goods::class,10)->create();
```

4、生成资源控制器
``` 
```
