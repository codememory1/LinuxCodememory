<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Пользователи</h4>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container d-center">
                    <div class="table-db-content" id="data-table" style="width:65%">
                        <a href="<?php echo e(route('FastDB.add-new-user')); ?>">
                            <span class="btn-createNewUser">Создать пользователя</span>
                        </a>
                        <a href="<?php echo e(route('FastDB.create-server')); ?>">
                            <span class="button-success">Создать Server</span>
                        </a>
                        <table>
                            <thead>
                                <th>
                                    Имя пользователя
                                </th>
                                <th>
                                    Пароль
                                </th>
                                <th>
                                    Действие
                                </th>
                            </thead>
                            <tbody>
								<?php (asort($listUsers[0]['listsUsers'])) ?>
								<?php $__currentLoopData = $listUsers[0]['listsUsers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyCommon => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyUsername => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php ($password = (empty($item['password'])) ? '<span style="color:#ff4a4a!important">Нет</span>' : '<span style="color:green!important">Да</span>') ?>
										<?php ($login = $item['username']) ?>
										<tr>
											<td>
												<?php echo e($login); ?>

											</td>
											<td>
												<?php echo $password; ?>

											</td>
											<td>
												<div style="display: flex;justify-content: center;align-items: center;">
													<a class="bg-black-radius" href="<?php echo e(route('FastDB.edit-user', ['id' => $keyCommon])); ?>" style="background-color:green;margin: 2px 3px;float: left;"><i data-tipfy-side="top" data-tipfy="Редактировать" class="far fa-pen"></i></a>

													<a class="bg-black-radius" href="<?php echo e(route('FastDB.edit-access-rights', ['id' => $keyCommon])); ?>" style="background-color:#129caa;margin: 2px 3px;float: left;"><i data-tipfy-side="top" data-tipfy="Привилегии" class="far fa-key"></i></a>

													<a class="bg-black-radius" href="<?php echo e(route('FastDB.deleteUser', ['id' => $keyCommon])); ?>" style="background-color:crimson;margin: 2px 3px;float: left;"><i data-tipfy-side="top" data-tipfy="Удалить" class="far fa-trash-alt"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/users.blade.php ENDPATH**/ ?>