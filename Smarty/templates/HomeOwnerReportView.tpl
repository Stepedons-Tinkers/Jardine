<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											
											<tr>
												<td colspan=4 class="dvInnerHeader">
													<table border=0 cellspacing=0 cellpadding=0 width=100%>
														<tr>
															<td colspan=3><b>{$APP.LBL_MONTHLY_DUES_STATEMENT}</b></td>
															<!--
															<td align=right>
																<b>{$MOD.LBL_YEAR}</b>
																<select>
																	<option>2012</option>
																	<option>2013</option>
																</select>
															</td>
															-->
														</tr>
													</table>
												</td>		
											</tr>
											
											<tr>
												<td  width=30%>
													<table border=0 cellspacing=0 cellpadding=0 width=100%>
														<tr>
															<td class="dvtCellLabel"  colspan=4 >
															<b><center>{$MOD.LBL_BILLING}</center></b>
															</td>
														</tr>
														<tr>
															<td  class="dvtCellInfo"  width=25%>Bill No.</td>
															<td  class="dvtCellInfo"  width=25%>Date of Bill</td>
															<td  class="dvtCellInfo"  width=25%>Amount</td>
															<td  class="dvtCellInfo"  width=25%>Status</td>
														</tr>
													</table>
													
												</td>
												<td width=30%>
													<table border=0 cellspacing=0 cellpadding=0 width=100%>
														<tr>
															<td class="dvtCellLabel"  colspan=4 >
															<b><center>{$MOD.LBL_PAYMENTS}</center></b>
															</td>
														</tr>
														<tr>
															<td  class="dvtCellInfo"  width=25%>Payment No.</td>
															<td  class="dvtCellInfo"  width=25%>Amount Paid</td>
															<td  class="dvtCellInfo"  width=25%>Type</td>
															<td  class="dvtCellInfo"  width=25%>Date</td>
														</tr>
													</table>
												</td>
												
												<td align=right width=15%>
													<table border=0 cellspacing=0 cellpadding=0 width=100%>
														<tr>
															<td class="dvtCellLabel"  colspan=2 >
															<b><center>Balance</center></b>
															</td>
														</tr>
														<tr>
															<td class="dvtCellInfo" width=50%>
																<center>Beginning</center>
															</td>
															<td class="dvtCellInfo" width=50%>
																<center>Ending</center>
															</td>
														</tr>
													</table>
												</td>
												
												<td  class="dvtCellLabel" style="padding:5px">
													<b><center>{$MOD.LBL_AGING}</center></b>
												</td>
											</tr>
											{assign var="begin_balance" value=0}
											{assign var="ending_balance" value=0}
											
											{foreach key=bill_record item=bill_payment from=$BILLSLIST}
												{assign var="payment_arr" value=$bill_payment.Payments}
												
												
												{assign var="bill_arr" value=$bill_payment.Bill}
													{assign var="billno" value=$bill_arr.billno}
													{assign var="date_of_bill" value=$bill_arr.date_of_bill}
													{assign var="amount" value=$bill_arr.amount}
													{assign var="b_status" value=$bill_arr.b_status}
													{assign var="aging" value=$bill_arr.aging}
												<tr>
													<td  width=30%> 
														<table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
															<tr>
																<td  class="dvtCellInfo"  width=25%>{$billno}</td>
																<td  class="dvtCellInfo"  width=25%>{$date_of_bill}</td>
																<td  class="dvtCellInfo"  width=25%>{$amount}</td>
																<td  class="dvtCellInfo"  width=25%>{$b_status}</td>
															</tr>
														</table>
													</td>
													<td  class="dvtCellLabel" width=30%>&nbsp;</td>
													<td  class="dvtCellInfo" width=15%>
														{assign var="begin_balance" value=$ending_balance+$amount}
														<center>{$begin_balance}</center>
													</td>
													<td  class="dvtCellInfo" width=25%><center>{$aging} days</center></td>
												</tr>
												
												{foreach key=payment_record item=payment_list from=$payment_arr}
													{assign var="payment_no" value=$payment_list.payment_no}
													{assign var="amount_paid" value=$payment_list.amount_paid}
													{assign var="p_type_payment" value=$payment_list.p_type_payment}
													{assign var="date_of_payment" value=$payment_list.date_of_payment}
													
													<tr>
														<td  class="dvtCellLabel" width=30%>&nbsp;</td>
														<td width=30%>
															<table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
															<tr>
																<td  class="dvtCellInfo"  width=25%>{$payment_no}</td>
																<td  class="dvtCellInfo"  width=25%>{$amount_paid}</td>
																<td  class="dvtCellInfo"  width=25%>{$p_type_payment}</td>
																<td  class="dvtCellInfo"  width=25%>{$date_of_payment}</td>
															</tr>
															</table>
														</td>
														<td width=15%>
															<table border=0 cellspacing=0 cellpadding=0 width=100%>
															<tr>
																<td class="dvtCellInfo" width=50%>
																	<center>{$begin_balance}</center>
																</td>
																<td class="dvtCellInfo" width=50%>
																	{assign var="ending_balance" value=$begin_balance-$amount_paid}
																	<center>{$ending_balance}</center>
																</td>
															</tr>
															</table>
														</td>
														<td  class="dvtCellInfo" width=25%>&nbsp;</td>
													</tr>
													{assign var="begin_balance" value=$ending_balance}
												{foreachelse}
													{assign var="ending_balance" value=$begin_balance}
												{/foreach}
												
											{/foreach}
									</table>		
								</td>
							</tr>
</table>
<br>
{include file ="HomeOwnerGraph.tpl"}
