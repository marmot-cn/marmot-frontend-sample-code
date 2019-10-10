<?php
namespace Common\Controller\Traits;

trait OperatControllerTrait
{
    /**
     * 如果是GET请求返回页面, POST请求提交数据
     */
    public function add()
    {
        if ($this->getRequest()->isGetMethod()) {
            return $this->addView();
        }

        return $this->addAction() ;
    }

    abstract protected function addView() : bool;
    /**
     * 请求数据前需要先判断数据是否合理: 验证添加场景
     * 验证成功进行 提交添加场景
     */
    abstract protected function addAction() : bool;

    public function edit(int $id)
    {
        if ($this->getRequest()->isGetMethod()) {
            return $this->editView($id);
        }

        return $this->editAction($id);
    }
    abstract protected function editView(int $id) : bool;

    abstract protected function editAction(int $id) : bool;
}
