<h1>Bridges</h1>

<table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
	<?php
		$odd = true;
		foreach ($bridges as $bridge)
		{
			$bridge_id = $bridge['Bridge']['id'];
			
			if ( !$bridge['UserBridge'] ) {
				$bridge['UserBridge'] = array(1); // allows the below array to go ahead
			}
			
			foreach ($bridge['UserBridge'] as $userBridge)
			{
				$user_bridge_id = null;
				if ( isset($userBridge['UserBridge']) ) {
					$user_bridge_id = $userBridge['UserBridge']['id'];
				}
				$odd = !$odd;
				?>
				<tbody class="<?php echo $odd ? 'odd' : 'even'; ?>">
					<?php
						if ( $user_bridge_id )
						{
							?>
							<tr>
								<td colspan="4" style="padding-left: 1em;">
									<h2 class="bridgeName"><?php echo $userBridge['UserBridge']['name']; ?></h2>
								</td>
							</tr>
							<?php
						}
					?>
					<tr>
						<td width="20%" style="text-align: left; vertical-align: middle; padding-left: 1em;"><?php echo $html->image($bridge['FromApp']['logo_url']); ?></td>
						<td width="40%" style="text-align: center; vertical-align: middle;"><?php echo $html->image('right.png'); ?></td>
						<td width="20%" style="text-align: right; vertical-align: middle;"><?php echo $html->image($bridge['ToApp']['logo_url']); ?></td>
						<td width="20%" style="text-align: left; vertical-align: middle; padding-left: 2em;">
							<?php
								$links = array();
								if ( $user_bridge_id ) {
									$links[] = $html->link('Delete', array('action' => 'delete', $user_bridge_id));
									$links[] = $html->link('Configure', array('action' => 'configure', $user_bridge_id));
									$links[] = $html->link('View Log', array('action' => 'view_log', $user_bridge_id));
									$links[] = $html->link('Add Another', array('action' => 'add', $bridge_id));
								}
								else {
									$links[] = $html->link('Add', array('action' => 'add', $bridge_id));
								}
								echo implode('<br />', $links);
							?>
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
				</tbody>
				<?php
			}
		}
	?>
</table>