<!-- sa-app__body -->
<div id="top" class="sa-app__body px-2 px-lg-4">
    <div class="container pb-6">
        <div class="py-5">
            <div class="row g-4 align-items-center">
                <div class="col">
                    <h1 class="h3 m-0">Thống kê</h1>
                </div>
            </div>
        </div>
        <div class="row g-4 g-xl-5">
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu hôm nay</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('today'),0,0,'.') ?> <span class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('today') ?>
                        <div class="saw-indicator__caption">So với hôm qua</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu tuần</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('this week'),0,0,'.') ?> <span class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('week') ?>
                        <div class="saw-indicator__caption">So với tuần trước</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu tháng</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('this month'),0,0,'.') ?> <span class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('month') ?>
                        <div class="saw-indicator__caption">So với tháng trước</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                <div class="card flex-grow-1 saw-pulse"
                    data-sa-container-query="{&quot;560&quot;:&quot;saw-pulse--size--lg&quot;}">
                    <div class="sa-widget-header saw-pulse__header">
                        <h2 class="sa-widget-header__title">Tổng bán tháng này</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-pulse__counter">44</div>
                    <div class="sa-widget-table saw-pulse__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì gà</a>
                                    </td>
                                    <td class="text-end">15</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì thịt heo</a>
                                    </td>
                                    <td class="text-end">11</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì ốp la</a>
                                    </td>
                                    <td class="text-end">7</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì thập cẩm</a>
                                    </td>
                                    <td class="text-end">4</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì chảo</a>
                                    </td>
                                    <td class="text-end">3</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì ngọt</a>
                                    </td>
                                    <td class="text-end">3</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì lạp xưởng</a>
                                    </td>
                                    <td class="text-end">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                <div class="card flex-grow-1 saw-chart"
                    data-sa-data="[
                        
                        <?php 
                        $count = count(revenue_year());
                        if($count) :
                            foreach (revenue_year() as $i => $row) :
                                $last_string = '';
                                if($i + 1 < $count) $last_string = ',';
                                echo <<<HTML
                                {&quot;label&quot;:&quot;Tháng {$row['month']}&quot;,&quot;value&quot;:{$row['total']} } {$last_string}
                                HTML;
                            endforeach;
                        endif
                        ?>
                        ]">
                    <div class="sa-widget-header saw-chart__header">
                        <h2 class="sa-widget-header__title">Doanh thu năm (<?= date('Y') ?>)</h2>
                    </div>
                    <div class="saw-chart__body">
                        <div class="saw-chart__container">
                            <canvas></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sa-app__body / end -->