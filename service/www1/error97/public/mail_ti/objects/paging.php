<?php

class Paging
{

    public $list = 18;
    public $block_ct = 10;
    public $block_num;
    public $page;
    public $block_start;
    public $block_end;
    public $total_page;
    public $total_block;
    public $start_num;
    public $row_num;

    function calculator($database, $table_name, $page, $join = null, $where)
    {
        if ($paging_result = $database->select($table_name, $rows = 'count(*)', $join, $where)) {

            $this->row_num = $paging_result[0]['count(*)'];

            $this->block_num = ceil($page / $this->block_ct);  // 현재 페이지 블록 구하기
            $this->block_start = (($this->block_num - 1) * $this->block_ct) + 1;  // 페이지 시작번호
            if ($this->block_start <= 1) $this->block_start = 1;
            $this->block_end = $this->block_start + $this->block_ct - 1;  // 페이지 마지막 번호
            $this->total_page = ceil($this->row_num / $this->list);  // 총 페이지 수 구하기
            if ($this->block_end > $this->total_page) $this->block_end = $this->total_page;  // 페이지 마지막 번호가 총 페이지 수 보다 크면 마지막 번호 == 총 페이지 수
            $this->total_block = ceil($this->total_page / $this->block_ct);  // 총 블록 개수
            $this->start_num = (($page - 1) * $this->list);
            if ($this->start_num <= 0) $this->start_num = 0;

            return true;
        } else {
            return false;
        }
    }

}

?>