<table>
	<tr>
		<td colspan="2" width="40%">No Kid</td>
		<td colspan="2" width="40%">Pregnant</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $nokid; ?></td>
		<td colspan="2"><?php echo $pregnant; ?></td>
	</tr>
</table>
<table style="margin-top: 10px;">
	<tr>
		<td colspan="2" width="40%">One Kid</td>
		<td width="20%"></td>
		<td colspan="2" width="40%">Two Kids</td>
	</tr>
	<tr>
		<td>0-2 Years</td>
		<td><?php echo $total_onekid_02year; ?></td>
		<td></td>
		<td>0-2 Years</td>
		<td><?php echo $total_twokids_02year; ?></td>
	</tr>
	<tr>
		<td>3-4 Years</td>
		<td><?php echo $total_onekid_34year; ?></td>
		<td></td>
		<td>3-4 Years</td>
		<td><?php echo $total_twokids_34year; ?></td>
	</tr>
	<tr>
		<td>5-6 Years</td>
		<td><?php echo $total_onekid_56year; ?></td>
		<td></td>
		<td>5-6 Years</td>
		<td><?php echo $total_twokids_56year; ?></td>
	</tr>
	<tr>
		<td>Totals</td>
		<td><?php echo $total_onekid_02year+$total_onekid_34year+$total_onekid_56year; ?></td>
		<td></td>
		<td>Totals</td>
		<td><?php echo $total_twokids_02year+$total_twokids_34year+$total_twokids_56year; ?></td>
	</tr>
</table>
<table style="margin-top: 10px;">
	<tr>
		<td colspan="2" width="40%">Three Kids</td>
		<td width="20%"></td>
		<td colspan="2" width="40%"</td>
	</tr>
	<tr>
		<td>0-2 Years</td>
		<td><?php echo $total_threekids_02year; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>3-4 Years</td>
		<td><?php echo $total_threekids_34year; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>5-6 Years</td>
		<td><?php echo $total_threekids_56year; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>Totals</td>
		<td><?php echo $total_threekids_02year+$total_threekids_34year+$total_threekids_56year; ?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>