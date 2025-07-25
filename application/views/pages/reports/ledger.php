<style>
	.mand{
		color:red;
	}
	label{
		min-width:90px;
	}
	.searchfrom label{
		width:105px;
	}
	input:not([type]),input[type="date"]{
		width:220px !important;
	}
	.link{ 
		color: #009fff; 
		cursor: pointer;
		/*text-decoration: underline;*/
	}
	table, th, td {
	   border: 1px solid #dad7d7;
	}
	.Totaltr td{
		background-color: #edf0f3;
	}
	.TotalRecord td{
		background: #11495a;
		font-weight: bold;
		color: white;
	}
	.AcntTypeTotal td{
		background: lightgrey;
		font-weight: bold;
		/*color: white;*/
	}
</style>


<div ng-app ="bank_accountsApp" id="PartyApp" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="padding-left:0px; padding-right:0px;">
    <div ng-controller ="LedgerReport as LedgerCtrl">
	<!-- <pre>{{ LedgerCtrl | json }}</pre> -->
        <div ng-view></div>
		<div class="col-lg-12">
			<form class="form-inline" ng-show="LedgerCtrl.selectedDiv != '/LedgerDetails'" ng-submit="LedgerCtrl.searchData()" name="PartyReportForm">
				<div class="form-group col-lg-4 col-md-6">
				  <label for="SearchBy"><span class="mand">*</span>Search By</label>
				  <select id="SearchBy" class="form-control" ng-model="LedgerCtrl.search.searchBy" style="width:220px;" required="">
					<option selected value="1">Ledger Account</option>
					<option value="7">Ledger vs Project R1</option>
					<option value="8">Ledger vs Project R2</option>
					<option value="2">Ledger Sub Account</option>
					<option value="3">Payee Party</option>
					<option value="4">Item</option>
					<option value="5">Project</option>
					<option value="6">Donor Party</option>
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '3' || LedgerCtrl.search.searchBy == '6'">
				  <label for="PartyName">Party</label>
				  <select id="PartyName" class="form-control" ng-model="LedgerCtrl.search.partyID" 
					  ng-options="Party.party_id as Party.party_name for Party in LedgerCtrl.Parties" style="width:230px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '4'">
				  <label for="ItemID">Items</label>
				  <select id="ItemID" class="form-control" ng-model="LedgerCtrl.search.itemID" 
					  ng-options="Item.item_id as Item.item_name for Item in LedgerCtrl.items" style="width:230px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '5'">
				  <label for="ProjectName">Project</label>
				  <select id="ProjectName" class="form-control" ng-model="LedgerCtrl.search.projectID" 
					  ng-options="Project.project_id as Project.project_name for Project in LedgerCtrl.projects" style="width:230px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '1'|| LedgerCtrl.search.searchBy == '7'|| LedgerCtrl.search.searchBy == '8'">
				  <label for="LedgerAcntID" title="Ledger Account">Account</label>
				  <select id="LedgerAcntID" class="form-control" ng-model="LedgerCtrl.search.ledgerAcntID" 
					  ng-options="LedgerAcnt.ledger_account_id as LedgerAcnt.ledger_account_name for LedgerAcnt in LedgerCtrl.ledgerAccounts" style="width:230px;" >
				  </select>
				</div>
				<div class="form-group col-lg-4 col-md-6" ng-show="LedgerCtrl.search.searchBy == '2'">
				  <label for="LedgerSubAcntID" title="Ledger Sub Account">Sub Account</label>
				  <select id="LedgerSubAcntID" class="form-control" ng-model="LedgerCtrl.search.ledgerSubAcntID" 
					  ng-options="LedgerSubAcnt.ledger_sub_account_id as LedgerSubAcnt.ledger_sub_account_name for LedgerSubAcnt in LedgerCtrl.ledgerSubAccounts" style="width:230px;" >
				  </select>
				</div>
				 <div class="form-group col-lg-4 col-md-6">
					<label for="startdate">Start Date</label>
					<input type="date" id="startdate" date-format="dd-MMM-yyyy" class="form-control" name="startdate" ng-model="LedgerCtrl.search.startDate">
				</div>
				<div class="form-group col-lg-4 col-md-6">
					<label for="enddate">End Date</label>
					<input type="date" id="enddate" date-format="dd-MMM-yyyy" class="form-control" name="enddate" ng-model="LedgerCtrl.search.endDate">
				</div>
				<div class="form-group col-lg-4 col-md-6">
					<label for="bankaccount">Bank Account</label>
					<select name="bankaccount" id="bankaccount" class="form-control" ng-model="LedgerCtrl.search.bankaccount" style="width:230px;">
						<option value=""></option>
						<?php
						foreach($bankaccounts as $tempbank){ ?>
						<option value='<?php echo $tempbank->bank_account_id; ?>'><?php echo $tempbank->account_name; ?></option>";
						<?php }
						?>
						<option value="Journal">Journal</option>
					</select>
					</div>
				<div class="form-group col-lg-12 col-md-12">
					<input style="margin-top: 15px; margin-left: 15px;" type="submit" class="btn btn-default" value="Search" ng-disabled="PartyReportForm.$invalid">
					<input style="margin-top: 15px;" type="button" class="btn btn-default" value="Clear" ng-click="LedgerCtrl.clear()">
				</div>
			</form>
		</div>
		<div class="col-lg-12" ng-show="LedgerCtrl.selectedDiv != '/LedgerDetails'" style="margin-top: 5px; ">
			<div class="panel panel-yellow " >
				<div class="panel-heading">Ledger Accounts</div>
				<div style="overflow-x: scroll">
					<table class="table table-hover " >
						<thead>
							<tr>
								<th rowspan="2">S.No.</th>
								<th rowspan="2" ng-if="!LedgerCtrl.recentsearch.searchID">Account</th>
								<th rowspan="2">Account Name</th>
								<th colspan="2" style="text-align: center;">Opening Balance</th>
								<th rowspan="2" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">Project</th>
								<th colspan="2" style="text-align: center;">Debits</th>
								<th colspan="2" style="text-align: center;">Credits</th>
								<th colspan="2" style="text-align: center;">Period Balance</th>
								<th colspan="6" ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat="(id,name) in LedgerCtrl.ProjectsList" ng-bind="name || 'Unassigned'" style="text-align: center;" ></th>
								<th colspan="2" style="text-align: center;">Closing Balance</th>
							</tr>
							<tr>
								<th >Bal. Type</th>
								<th class="num-align">Balance</th>
								<th >#</th>
								<th class="num-align">Amount</th>
								<th >#</th>
								<th class="num-align">Amount</th>
								<th >Bal. Type</th>
								<th >Balance</th>
								
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" >#</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Debit</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >#</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Credit</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >Bal Type</th>
								<th ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-end >Bal</th>
								<th >Bal. Type</th>
								<th class="num-align">Balance</th>
							</tr>
						</thead>
						<tbody>
							<tbody ng-repeat="(acnttype,acntTypeData) in LedgerCtrl.PartiesData">
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '1'">								
									<td  colspan="{{LedgerCtrl.recentsearch.searchID ? 8 : 13}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '7'">								
									<td  colspan="{{LedgerCtrl.recentsearch.searchID ? 9 : 14}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '8'">								
									<td  colspan="{{LedgerCtrl.getColSpan()}}" ng-bind="acnttype" style="background-color: #fbf9c9;"></td>
								</tr>
								<tr ng-repeat-start="(typename,TypePartiesData) in acntTypeData">
									<td rowspan="{{LedgerCtrl.getRowSpan(TypePartiesData)}}" ng-bind="$index+1"></td>
									<td ng-if="!LedgerCtrl.recentsearch.searchID" rowspan="{{LedgerCtrl.getRowSpan(TypePartiesData)}}" ng-bind="typename"></td>
								</tr>
								<tr ng-repeat="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy != '7' && LedgerCtrl.recentsearch.searchBy != '8'">
									<td ng-bind="PartyData.account_name"></td>
									<!-- <td ng-bind="PartyData.ledger_account_id"></td> -->
									<td ng-if="typename === 'Bank'" 
										ng-bind="LedgerCtrl.getBankOpeningBalanceByAccountName(PartyData.account_name).balance_type == 1 ? 'Debit' : 'Credit'">
									</td>
									<td style="text-align:right;" ng-if="typename === 'Bank'" ng-bind="LedgerCtrl.getBankOpeningBalanceByAccountName(PartyData.account_name).balance"></td>

									<!-- If typename not 'Bank', print empty cells to keep table layout -->
									<td ng-if="typename !== 'Bank'"></td>
									<td ng-if="typename !== 'Bank'"></td>
									<td class="num-align" ng-if=" LedgerCtrl.recentsearch.searchBy == '7'" ></td>
									<td class="num-align" ng-bind="PartyData.PayTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="PartyData.PayTotal | currency:''"></td>
									<td class="num-align" ng-bind="PartyData.RecptTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="PartyData.RecptTotal | currency:''"></td>
									<td ng-bind="(parseFloat(PartyData.PayTotal) > parseFloat(PartyData.RecptTotal)) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(PartyData.PayTotal - PartyData.RecptTotal) | abs | currency:''"></td>
									
									<td ng-if="typename === 'Bank'" id="closing_balance_type"
										ng-bind="LedgerCtrl.getClosingBalance(PartyData.account_name, PartyData.PayTotal, PartyData.RecptTotal).type">
									</td>

									<td style="text-align:right;" ng-if="typename === 'Bank'" id="closing_balance"
										ng-bind="LedgerCtrl.getClosingBalance(PartyData.account_name, PartyData.PayTotal, PartyData.RecptTotal).amount | currency:''">
									</td>
									
									<td ng-if="typename !== 'Bank'"></td>
									<td ng-if="typename !== 'Bank'"></td>

								</tr>
								
								<tr ng-repeat-start="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">
									<td ng-bind="LedgerCtrl.getAccountName(PartyData)"></td>
									<td ></td>
									<td ></td>
									<td ng-if=" LedgerCtrl.recentsearch.searchBy == '7'" >
										<!--<div ng-repeat="PrjctTrnx in PartyData">
											<span ng-if="PrjctTrnx.project_name || PrjctTrnx.amount " ng-bind="(PrjctTrnx.project_name || 'Unassigned')+':'+ (PrjctTrnx.amount | currency:'')"></span>
										</div>-->
									</td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'PayTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'PayTotal') | currency:''"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'RecptTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'RecptTotal') | currency:''"></td>
									<td ng-bind="(parseFloat(LedgerCtrl.sumByFloat(PartyData,'PayTotal')) > parseFloat(LedgerCtrl.sumByFloat(PartyData,'RecptTotal'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(PartyData,'PayTotal') - LedgerCtrl.sumByFloat(PartyData,'RecptTotal')) | abs | currency:''"></td>
									<td></td>
									<td></td>
								</tr>


								<tr ng-repeat-end ng-repeat="PrjctTrnx in PartyData" ng-if="LedgerCtrl.recentsearch.searchBy == '7'">
									<td ></td>
									<td ></td>
									<td ></td>
									<td class="num-align" ng-bind="PrjctTrnx.project_name || 'Unassigned'" ></td>
									<td class="num-align" ng-bind="PrjctTrnx.PayTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PrjctTrnx,'','Debit', PrjctTrnx.project_id)" ng-bind="PrjctTrnx.PayTotal | currency:''"></td>
									<td class="num-align" ng-bind="PrjctTrnx.RecptTotalCnt"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PrjctTrnx,'','Credit', PrjctTrnx.project_id)" ng-bind="PrjctTrnx.RecptTotal | currency:''"></td>
									<td ng-bind="(parseFloat(PrjctTrnx.PayTotal) > parseFloat(PrjctTrnx.RecptTotal)) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(PrjctTrnx.PayTotal - PrjctTrnx.RecptTotal) | abs | currency:''"></td>
									<td></td>
									<td></td>
								</tr>


								<tr ng-repeat="PartyData in TypePartiesData" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<td ng-bind="LedgerCtrl.getAccountName(PartyData)"></td>
									<td ></td>
									<td ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'PayTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'PayTotal') | currency:''"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(PartyData,'RecptTotalCnt')"></td>
									<td class="num-align link" ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit')" ng-bind="LedgerCtrl.sumByFloat(PartyData,'RecptTotal') | currency:''"></td>
									<td ng-bind="(parseFloat(LedgerCtrl.sumByFloat(PartyData,'PayTotal')) > parseFloat(LedgerCtrl.sumByFloat(PartyData,'RecptTotal'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(PartyData,'PayTotal') - LedgerCtrl.sumByFloat(PartyData,'RecptTotal')) | abs | currency:''"></td>


									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList">
										<span ng-bind="LedgerCtrl.getProjectCount('Debit', id, PartyData)"></span>
									</td>
									<td class="num-align link" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-click="LedgerCtrl.showTrnxs(PartyData,'','Debit', id)" ng-bind="LedgerCtrl.getProjectAmount('Debit', id, PartyData) | currency:''"></span>
									</td>
									<td  ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectCount('Credit', id, PartyData)"></span>
									</td>
									<td class="num-align link" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-click="LedgerCtrl.showTrnxs(PartyData,'','Credit', id)" ng-bind="LedgerCtrl.getProjectAmount('Credit', id, PartyData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectAmount('Debit', id, PartyData)) > parseFloat(LedgerCtrl.getProjectAmount('Credit', id, PartyData))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectAmount('Debit', id, PartyData) - LedgerCtrl.getProjectAmount('Credit', id, PartyData)) | abs | currency:''"></span>
									</td>
									<td></td>
									<td></td>


								</tr>


								<tr class="TotalRecord" ng-repeat-end >
									<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3}}" style="text-align: right;">Total</td>
									<td><span ng-bind="
										(first = LedgerCtrl.getFirstItem(TypePartiesData)) && 
										(first.typename === 'Bank' 
										? (LedgerCtrl.getOpeningBalanceTotal1(TypePartiesData) < 0 ? 'Debit' : 'Credit') 
										: (first.balance_type == 1 ? 'Debit' : (first.balance_type == 2 ? 'Credit' : ' '))
										)
									">
									</span></td>
									<td class="text-right" ng-bind="LedgerCtrl.getOpeningBalanceTotal(TypePartiesData) | currency:''"></td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(TypePartiesData,'PayTotalCnt', (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))"></td>
									<td class="num-align link" ng-bind="LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" style="text-align: right;"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(TypePartiesData,'RecptTotalCnt',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))"></td>
									<td class="num-align link" ng-bind="LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" style="text-align: right;"></td>
									<td ng-bind="(LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) > LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) ? 'Debit' : 'Credit'"></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(TypePartiesData,'PayTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) - LedgerCtrl.sumByFloat(TypePartiesData,'RecptTotal',(LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) | abs | currency:''"></td>
									
									<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, TypePartiesData)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, TypePartiesData)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, TypePartiesData) - LedgerCtrl.getProjectTotalAmount('Credit', id, TypePartiesData)) | abs | currency:''"></span>
									</td>
									<td ng-bind="LedgerCtrl.getDominantBalanceType(TypePartiesData)"></td>
									<td class="text-right" ng-bind="LedgerCtrl.getFinalTotalAmountAdjusted(TypePartiesData) | currency:''"></td>

								</tr>
								<tr ng-if="LedgerCtrl.recentsearch.searchBy == '1' || LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'" class="AcntTypeTotal">
									<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3}}" ng-bind="acnttype + 'Total'" style="text-align: right;"></td>
									<td></td>
									<td class="text-right" ng-bind="LedgerCtrl.getOpeningBalanceTotalByType(acntTypeData) | currency:''"></td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(acntTypeData,'PayTotalCnt',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByInt(acntTypeData,'RecptTotalCnt',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))" ></td>
									<td class="num-align" ng-bind="LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) | currency:''" ></td>
									<td ng-bind="(LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) > LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) ? 'Debit' : 'Credit'" ></td>
									<td class="num-align" ng-bind="(LedgerCtrl.sumByFloat(acntTypeData,'PayTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8')) - LedgerCtrl.sumByFloat(acntTypeData,'RecptTotal',true, (LedgerCtrl.recentsearch.searchBy == '7' || LedgerCtrl.recentsearch.searchBy == '8'))) | abs | currency:''" ></td>
									
									<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, acntTypeData, true)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, acntTypeData, true)"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
										<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true) | currency:''"></span>
									</td>
									<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true))) ? 'Debit' : 'Credit'"></span>
									</td>
									<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
										<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, acntTypeData, true) - LedgerCtrl.getProjectTotalAmount('Credit', id, acntTypeData, true)) | abs | currency:''"></span>
									</td>
									<td></td>
									<td class="text-right" ng-bind="LedgerCtrl.getFinalTotalSumByAccountType(acntTypeData) | currency:''"></td>
								</tr>
							</tbody>
							<tr class="Totaltr" ng-show="LedgerCtrl.PartiesData && keys(LedgerCtrl.PartiesData).length > 0">
								<td colspan="{{LedgerCtrl.recentsearch.searchID ? 2 : 3 }}" style="text-align: right;">Grand Total</td>
								<td ></td>
								<td class="text-right" ng-bind="LedgerCtrl.getGrandOpeningBalanceTotal() | currency:''"></td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '7'"></td>
								<td class="num-align" ng-bind="LedgerCtrl.getTotal('TPC')"></td>
								<td class="num-align " ng-bind="LedgerCtrl.getTotal('TP') | currency:''" style="text-align: right;"></td> <?php //ng-click="LedgerCtrl.showTrnxs({},'','Debit')" ?>
								<td class="num-align" ng-bind="LedgerCtrl.getTotal('TRC')"></td>
								<td class="num-align " ng-bind="LedgerCtrl.getTotal('TR') | currency:''" style="text-align: right;"></td> <?php //ng-click="LedgerCtrl.showTrnxs({},'','Credit')" ?>
								<td ng-bind="LedgerCtrl.getTotal('TP') > LedgerCtrl.getTotal('TR') ? 'Debit' : 'Credit'"></td>
								<td class="num-align" ng-bind="(LedgerCtrl.getTotal('TP') - LedgerCtrl.getTotal('TR')) | abs | currency:''"></td>
								
								
								<td ng-repeat-start="(id,name) in LedgerCtrl.ProjectsList" ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="LedgerCtrl.getProjectTotalCount('Debit', id, LedgerCtrl.PartiesData, true, true)"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true) | currency:''"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
									<span ng-bind="LedgerCtrl.getProjectTotalCount('Credit', id, LedgerCtrl.PartiesData, true, true)"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'" >
									<span ng-bind="LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true) | currency:''"></span>
								</td>
								<td ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="(parseFloat(LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true)) > parseFloat(LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true))) ? 'Debit' : 'Credit'"></span>
								</td>
								<td ng-repeat-end ng-if="LedgerCtrl.recentsearch.searchBy == '8'">
									<span ng-bind="(LedgerCtrl.getProjectTotalAmount('Debit', id, LedgerCtrl.PartiesData, true, true) - LedgerCtrl.getProjectTotalAmount('Credit', id, LedgerCtrl.PartiesData, true, true)) | abs | currency:''"></span>
								</td>
								<td></td>
								<td class="text-right" ng-bind="LedgerCtrl.getGrandFinalTotalSum() | currency:''"></td>
							</tr>
							<tr class="success" align="center" ng-show="!LedgerCtrl.PartiesData || keys(LedgerCtrl.PartiesData).length == 0"><td colspan="14">There are no transactions for selected search criteria</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
</div>


<script>
	
	angular.module('bank_accountsApp', ['ngRoute'])
	.controller('LedgerReport', ['$http','$location','$rootScope','DetailsDataProv', '$rootScope','DateFormater', "$scope", function($http,$location,$rootScope,DetailsDataProv, $rootScope,DateFormater, $scope) {
		$rootScope.keys = Object.keys;
		$scope.parseInt = parseInt;
		$scope.parseFloat = parseFloat;
		var self = this;
		$rootScope.$on('$routeChangeSuccess',function(){
			self.selectedDiv = $location.path();
		});
		$("#LefNaveLedgerReport").addClass("active");
		self.PartiesData = [];
		self.search = {"searchBy":"1"};
		self.recentsearch = {};
		self.clear = function(){
			self.search = {};
		};
		self.Parties = <?=json_encode($parties)?>;
		self.Parties = [{party_id: '', party_name:'All' }, ...self.Parties];
		self.projects = <?=json_encode($projects)?>;
		self.projects = [{project_id: '' ,project_name:'All' }, ...self.projects];
		self.ledgerAccounts = <?=json_encode($ledger_accounts)?>;
		self.ledgerAccounts = [{ledger_account_id: '', ledger_account_name: 'All'}, ...self.ledgerAccounts];
		self.ledgerSubAccounts = <?=json_encode($ledger_sub_accounts)?>;
		self.ledgerSubAccounts =[{ledger_sub_account_id: ' ',ledger_sub_account_name: 'All'}, ...self.ledgerSubAccounts];
		self.items = <?=json_encode($items)?>;
		self.items  = [{item_id: '',item_name:'All' }, ...self.items ];
		self.getAccountName = function(vData){
			if(vData){
				return vData[0].account_name;
			}
		};
		self.bankOpeningBalances = <?= json_encode($bank_opening_balances) ?>;
		self.getBankOpeningBalanceByAccountName = function(accountName) {
			var found = self.bankOpeningBalances.find(function(item) {
				return item.account_name === accountName;
			});
			if(found) {
				return found;
			}
			return { balance: '', balance_type: '' };
		};
		self.getProjectTotalCount = function(vType, id, vArray, vTypeTotal,vTotals){
			
			vArray = _.flatten(_.values(vArray));
			var vTempArray = [];
			$.each(vArray, function(i,v){
				vTempArray.push(_.flatten(_.values(v)));
			});
			if(vTypeTotal === true)
				vArray = _.flatten(vTempArray);
			if(vTotals){
				vArray = _.flatten(_.flatten(_.map(vArray,_.values)));
			}
			var vPayTotal = 0;
			$.each(vArray, function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal += parseInt(v.PayTotalCnt);
					}
					else if(vType == "Credit" )
					{
						vPayTotal += parseInt(v.RecptTotalCnt);
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectTotalAmount = function(vType, id, vArray, vTypeTotal, vTotals){
			vArray = _.flatten(_.values(vArray));
			var vTempArray = [];
			$.each(vArray, function(i,v){
				vTempArray.push(_.flatten(_.values(v)));
			});
			if(vTypeTotal === true)
				vArray = _.flatten(vTempArray);
			if(vTotals){
				vArray = _.flatten(_.flatten(_.map(vArray,_.values)));
			}
			
			var vPayTotal = 0;
			$.each(vArray, function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal += parseFloat(v.PayTotal);
					}
					else if(vType == "Credit" )
					{
						vPayTotal += parseFloat(v.RecptTotal);
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectCount = function(vType, id, PartyData){
			var vPayTotal = 0;
			$.each(_.flatten(_.values(PartyData)), function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal = v.PayTotalCnt;
					}
					else if(vType == "Credit" )
					{
						vPayTotal = v.RecptTotalCnt;
					}
				}
			});
			return vPayTotal;
		};
		self.getProjectAmount = function(vType, id, PartyData){
			var vPayTotal = 0;
			$.each(_.flatten(_.values(PartyData)), function(i,v){
				if(v.project_id === id){
					if(vType == "Debit")
					{
						vPayTotal = v.PayTotal;
					}
					else if(vType == "Credit" )
					{
						vPayTotal = v.RecptTotal;
					}
				}
			});
			return vPayTotal;
		};
		self.getColSpan = function(){
			return (Object.keys(self.ProjectsList).length*6) + (self.recentsearch.searchID ? 9 : 13); 
		};
		self.getRowSpan = function(vData){
			if(self.recentsearch.searchBy == 7){
				return Object.keys(vData).length + _.flatten(_.values(vData)).length + 1;
			}
			if( self.recentsearch.searchBy == 8){
				return Object.keys(vData).length + 1;
				
			}
			else {
				return vData.length + 1;
			}
		};
		self.ProjectsList = {};
		self.searchData = function(){
			var vTempSearch = {"bankAccount":self.search.bankaccount, "searchBy":self.search.searchBy,"startDate":DateFormater.convertJsDate(self.search.startDate),"endDate":DateFormater.convertJsDate(self.search.endDate)};
			if(self.search.searchBy == "1" || self.search.searchBy == "7" || self.search.searchBy == "8")
				vTempSearch["searchID"]=self.search.ledgerAcntID;
			else if(self.search.searchBy == "2")
				vTempSearch["searchID"]=self.search.ledgerSubAcntID;
			else if(self.search.searchBy == "3" || self.search.searchBy == "6")
				vTempSearch["searchID"]=self.search.partyID;
			else if(self.search.searchBy == "4")
				vTempSearch["searchID"]=self.search.itemID;
			else if(self.search.searchBy == "5")
				vTempSearch["searchID"]=self.search.projectID;
			
			return $http.post('<?php echo base_url(); ?>index.php/report/getledgerdata',vTempSearch).then(
				function(response) {
					if(self.search.searchBy == "1" || self.search.searchBy == "7" || self.search.searchBy == "8"){
						if(self.search.searchBy == "8"){
							self.ProjectsList = {};
							$.each(response.data,function(i,v){
								if(v.project_id)
									self.ProjectsList[v.project_id] = v.project_name;
							});
						}
						self.PartiesData = _.groupBy(response.data,"accounttype");
						_.forEach(self.PartiesData, function(v,k){
							self.PartiesData[k] = _.groupBy(v,"typename");
						});
						if(self.search.searchBy == "7" || self.search.searchBy == "8"){
							_.forEach(self.PartiesData, function(v,k){
								_.forEach(v, function(v1,k1){
									self.PartiesData[k][k1] = _.groupBy(v1,"account_number");
								});
							});
						}
						var vSortOrder = ["Income","Expenditure","Assets","Liabilities"];
						var vParties = {};
						_.forEach(vSortOrder, function(v,i){
							if(self.PartiesData[v]){
								vParties[v] = self.PartiesData[v];
							}
						});
						self.PartiesData = vParties;
						// Get opening balance for each ledger_account_id
						_.forEach(response.data, function(item) {
						 	self.getOpeningBalance(item);
						});
					}else{
						self.PartiesData = _.groupBy(response.data,"typename");
						var v = self.PartiesData;
						self.PartiesData = {};
						self.PartiesData[""] = v; 
					}
					self.recentsearch = {};
					jQuery.extend(true,self.recentsearch,vTempSearch);
				}, function(errResponse) {
					console.error(errResponse.data.msg);
				}
			);

		};
		self.getOpeningBalance = function(item) {
			var vTempSearch = { "ledger_account_id": item.ledger_account_id , "start_date": formatDate(self.search.startDate)};
		 	return $http.post('<?php echo base_url(); ?>index.php/report/getOpeningBalance', vTempSearch).then(
		 		function(response) {
		 			if (response.data && response.data.balance !== undefined) {
		 				item.opening_balance = parseFloat(response.data.balance);
						item.balance_type = parseInt(response.data.balance_type);
		 			} else {
		 				item.opening_balance = 0;
		 			}
		 		},
		 		function(errResponse) {
		 			item.opening_balance = 0;
		 			console.error("Error fetching opening balance: " + errResponse.data.msg);
		 		}
		 	);
		};
		// self.getOpeningBalanceTotal = function(data) {
		// 	var total = _.reduce(_.flattenDeep(_.values(data)), function(sum, item) {
		// 	var balance = 0;
		// 	var balanceType = null;
		// 	if (item.account_name) {
		// 			sum = parseFloat(item.opening_balance) || 0;
		// 	}
		// 	if(item.accounttype == "Assets" && item.typename == "Bank") {
		// 			var found = self.bankOpeningBalances.find(function(item1) {
		// 				if (item1) {
		// 					balance = Math.abs(parseFloat(item1.balance) || 0); // Always positive
		// 					balanceType = item1.balance_type;
		// 				} else {
		// 					balance = Math.abs(parseFloat(item1.opening_balance) || 0); // Always positive
		// 					balanceType = item1.balance_type;
		// 				}
		// 				if (balanceType === "1") {
		// 					sum -= balance;
		// 				} else if (balanceType === "2") {
		// 					sum += balance;
		// 				}
		// 			});
		// 	}
		// 		return sum;
    	// 	}, 0);
    	// 	return Math.abs(total);
		// };
		self.getOpeningBalanceTotal = function(data) {
			var total = _.reduce(_.flattenDeep(_.values(data)), function(sum, item) {
				if (!item || !item.account_name) {
					return sum;
				}
				var balance = 0;
				var balanceType = null;
				var openingBalance = parseFloat(item.opening_balance) || 0;
				if (item.accounttype === "Assets" && item.typename === "Bank") {
					var match = self.bankOpeningBalances.find(function(item1) {
						return item1 && item1.account_name === item.account_name;
					});

					if (match) {
						balance = Math.abs(parseFloat(match.balance) || 0);
						balanceType = match.balance_type;
					} else {
						balance = Math.abs(openingBalance);
						balanceType = item.balance_type || null;
					}
					if (balanceType === "1") {
						sum -= balance;
					} else if (balanceType === "2") {
						sum += balance;
					}
				} else {
					sum += openingBalance;
				}
				return sum;
			}, 0);
			return Math.abs(total);
		};
		self.getOpeningBalanceTotal1 = function(data) {
			return _.reduce(_.flattenDeep(_.values(data)), function(sum, item) {
				var balance = 0;
				var balanceType = null;
				var found = self.bankOpeningBalances.find(function(item1) {
					return item1.account_name === item.account_name;
				});

				if (found) {
					balance = parseFloat(found.balance) || 0;
					balanceType = found.balance_type;
				} else {
					balance = parseFloat(item.opening_balance) || 0;
					balanceType = item.balance_type;
				}
				if (balanceType === "1") {
					sum -= balance;
				} else if (balanceType === "2") {
					sum += balance;
				} else {
					sum += 0;
				}
				return sum;
			}, 0);
		};
		self.getFirstItem = function(data) {
			let flat = _.flatten(_.flatten(_.values(data)));
			return flat[0] || {};
		};
		self.getOpeningBalanceTotalByType = function(acntTypeData) {
			let totalDebit = 0;
			let totalCredit = 0;
			let addedTypenames = {};

			angular.forEach(acntTypeData, function(typenameGroup, typename) {
				if (addedTypenames[typename]) return;

				let flatItems = [];
				if (typeof typenameGroup === 'object' && !Array.isArray(typenameGroup)) {
					angular.forEach(typenameGroup, function(accountGroup) {
						if (Array.isArray(accountGroup)) {
							flatItems = flatItems.concat(accountGroup);
						}
					});
				} else if (Array.isArray(typenameGroup)) {
					flatItems = typenameGroup;
				}

				angular.forEach(flatItems, function(item) {
					if (!item || !item.account_name) return;

					let balance = 0;
					let balanceType = item.balance_type;

					if (item.accounttype === "Assets" && item.typename === "Bank") {
						let match = self.bankOpeningBalances.find(function(bankItem) {
							return bankItem && bankItem.account_name === item.account_name;
						});
						if (match) {
							balance = parseFloat(match.balance) || 0;
							balanceType = match.balance_type || balanceType;
						} else {
							balance = parseFloat(item.opening_balance) || 0;
						}
					} else {
						balance = parseFloat(item.opening_balance) || 0;
					}

					if (balanceType === 1 || balanceType === "1") {
						totalDebit += balance;
					} else if (balanceType === 2 || balanceType === "2") {
						totalCredit += balance;
					}
				});

				addedTypenames[typename] = true;
			});

			// Net balance = Debit - Credit (positive = Debit, negative = Credit)
			let netBalance =  totalCredit - totalDebit;

			return netBalance;
		};
		self.getFinalTotalAmountAdjusted = function(data) {
			const isFiltered = self.recentsearch.searchBy === '7' || self.recentsearch.searchBy === '8';
			const opening = self.getOpeningBalanceTotal(data) || 0;
			const pay = self.sumByFloat(data, 'PayTotal', isFiltered) || 0;
			const recpt = self.sumByFloat(data, 'RecptTotal', isFiltered) || 0;

			if (opening === 0 && pay === 0 && recpt === 0) return 0;

			let openingCredit = 0;
			let openingDebit = 0;

			_.forEach(_.flattenDeep(_.values(data)), function(item) {
				if (!item || !item.account_name) return;

				let balance = 0;
				let type = null;

				if (item.accounttype === "Assets" && item.typename === "Bank") {
					const match = self.bankOpeningBalances.find(function(bankItem) {
						return bankItem && bankItem.account_name === item.account_name;
					});
					if (match) {
						balance = Math.abs(parseFloat(match.balance) || 0);
						type = match.balance_type;
					} else {
						balance = Math.abs(parseFloat(item.opening_balance) || 0);
						type = item.balance_type;
					}
				} else {
					balance = Math.abs(parseFloat(item.opening_balance) || 0);
					type = item.balance_type;
				}

				if (type === "2" || type === 2) {
					openingCredit += balance;
				} else if (type === "1" || type === 1) {
					openingDebit += balance;
				}
			});

			let openingType = null;
			if (openingCredit > openingDebit) {
				openingType = 'Credit';
			} else if (openingDebit > openingCredit) {
				openingType = 'Debit';
			} else {
				openingType = null;
			}

			const netType = pay > recpt ? 'Debit' : (recpt > pay ? 'Credit' : null);
			const netDiff = Math.abs(pay - recpt);

			if (!openingType || !netType) return netDiff;

			if (openingType === netType) {
				return opening + netDiff;
			} else {
				return Math.abs(opening - netDiff);
			}
		};
		self.getDominantBalanceType = function(data) {
			const isFiltered = self.recentsearch.searchBy === '7' || self.recentsearch.searchBy === '8';

			const pay = self.sumByFloat(data, 'PayTotal', isFiltered) || 0;
			const recpt = self.sumByFloat(data, 'RecptTotal', isFiltered) || 0;

			let openingCredit = 0;
			let openingDebit = 0;

			_.forEach(_.flattenDeep(_.values(data)), function(item) {
				if (!item || !item.account_name) return;

				let balance = 0;
				let type = null;

				if (item.accounttype === "Assets" && item.typename === "Bank") {
					const match = self.bankOpeningBalances.find(function(bankItem) {
						return bankItem && bankItem.account_name === item.account_name;
					});
					if (match) {
						balance = Math.abs(parseFloat(match.balance) || 0);
						type = match.balance_type;
					} else {
						balance = Math.abs(parseFloat(item.opening_balance) || 0);
						type = item.balance_type;
					}
				} else {
					balance = Math.abs(parseFloat(item.opening_balance) || 0);
					type = item.balance_type;
				}

				if (type === "2" || type === 2) {
					openingCredit += balance;
				} else if (type === "1" || type === 1) {
					openingDebit += balance;
				}
			});

			let opening = openingDebit > openingCredit ? openingDebit : openingCredit;
			let openingType = null;

			if (openingCredit > openingDebit) {
				openingType = 'Credit';
			} else if (openingDebit > openingCredit) {
				openingType = 'Debit';
			}

			const netDiff = Math.abs(pay - recpt);
			const netType = pay > recpt ? 'Debit' : (pay < recpt ? 'Credit' : null);

			if (opening === 0 && (pay !== 0 || recpt !== 0)) {
				return netType;
			}

			if (opening === 0 && netDiff === 0) return '';

			if (!openingType || !netType) return '';

			if (opening > netDiff) {
				return openingType;
			} else {
				return netType;
			}
		};
		self.getFinalTotalSumByAccountType = function(acntTypeData) {
			let totalDebit = 0;
			let totalCredit = 0;

			const flattened = _.flattenDeep(_.map(acntTypeData, typenameGroup => {
				if (_.isObject(typenameGroup) && !Array.isArray(typenameGroup)) {
					return _.map(typenameGroup, accountGroup => {
						if (_.isObject(accountGroup)) {
							return _.flattenDeep(_.values(accountGroup));
						}
						return [];
					});
				} else if (Array.isArray(typenameGroup)) {
					return typenameGroup;
				}
				return [];
			}));

			angular.forEach(flattened, function(item) {
				if (!item || !item.account_name) return;

				let openingCredit = 0;
				let openingDebit = 0;
				let balance = 0;
				let type = null;

				if (item.accounttype === "Assets" && item.typename === "Bank") {
					const match = self.bankOpeningBalances.find(function(bankItem) {
						return bankItem && bankItem.account_name === item.account_name;
					});
					if (match) {
						balance = Math.abs(parseFloat(match.balance) || 0);
						type = match.balance_type;
					} else {
						balance = Math.abs(parseFloat(item.opening_balance) || 0);
						type = item.balance_type;
					}
				} else {
					balance = Math.abs(parseFloat(item.opening_balance) || 0);
					type = item.balance_type;
				}

				if (type === "2" || type === 2) {
					openingCredit += balance;
				} else if (type === "1" || type === 1) {
					openingDebit += balance;
				}

				const pay = parseFloat(item.PayTotal) || 0;
				const recpt = parseFloat(item.RecptTotal) || 0;

				if (balance === 0 && pay === 0 && recpt === 0) return;

				let openingType = null;
				if (openingCredit > openingDebit) {
					openingType = 'Credit';
				} else if (openingDebit > openingCredit) {
					openingType = 'Debit';
				}

				const netDiff = Math.abs(pay - recpt);
				const netType = pay > recpt ? 'Debit' : (pay < recpt ? 'Credit' : null);

				if (!openingType && netType) {
					if (netType === 'Debit') {
						totalDebit += netDiff;
					} else if (netType === 'Credit') {
						totalCredit += netDiff;
					}
					return;
				}

				if (!openingType || !netType) return;

				let adjustedAmount = 0;
				if (openingType === netType) {
					adjustedAmount = balance + netDiff;
				} else {
					adjustedAmount = Math.abs(balance - netDiff);
				}

				if ((balance >= netDiff && openingType === 'Debit') || (balance < netDiff && netType === 'Debit')) {
					totalDebit += adjustedAmount;
				} else {
					totalCredit += adjustedAmount;
				}
			});

			return totalCredit - totalDebit;
		};
		self.getClosingBalance = function(accountName, payTotal, recptTotal) {
			var opening = self.getBankOpeningBalanceByAccountName(accountName) || {};
			var openingAmt = parseFloat(opening.balance) || 0;
			var openingType = opening.balance_type; // "1" for Debit, "2" for Credit

			var netPay = parseFloat(payTotal) || 0;
			var netRecpt = parseFloat(recptTotal) || 0;
			var netAmt = Math.abs(netPay - netRecpt);
			var netType = (netPay >= netRecpt) ? "1" : "2"; // "1": Debit, "2": Credit

			var finalAmt = 0;
			var finalType = "Debit";

			if (openingType === netType) {
				finalAmt = openingAmt + netAmt;
				finalType = (openingType === "1") ? "Debit" : "Credit";
			} else {
				if (openingAmt > netAmt) {
					finalAmt = openingAmt - netAmt;
					finalType = (openingType === "1") ? "Debit" : "Credit";
				} else {
					finalAmt = netAmt - openingAmt;
					finalType = (netType === "1") ? "Debit" : "Credit";
				}
			}

			return {
				type: finalType,
				amount: finalAmt
			};
		};
		self.getGrandFinalTotalSum = function() {
			let grandTotal = 0;

			angular.forEach(self.PartiesData, function(acntTypeData) {
				const total = self.getFinalTotalSumByAccountType(acntTypeData);
				grandTotal += total;
			});

			return grandTotal;
		};
		self.getGrandOpeningBalanceTotal = function() {
			let grandTotal = 0;
			angular.forEach(self.PartiesData, function(acntTypeData) {
				grandTotal += self.getOpeningBalanceTotalByType(acntTypeData);
			});
			return grandTotal;
		};
		self.getPartyName = function(vPartID){
			var vPartyName = "";
			$.each(self.Parties,function(i,v){
				if(v.party_id == vPartID){
					vPartyName = v.party_name;
					return false;
				}
			});
			return vPartyName;
		};
		self.sumByInt = function(vArray,vKey, vDeepObject, vLedgerProjTotal){
			if(vDeepObject === true){
				vArray = _.flatten(_.values(vArray));
			}
			if(vLedgerProjTotal === true){
				var vTempArray = [];
				$.each(vArray, function(i,v){
					vTempArray.push(_.flatten(_.values(v)));
				});
				vArray = _.flatten(vTempArray);
			}
			var vTotal = 0 ;
			if(vArray){
				vTotal = _.sumBy(vArray, function(o){
						return parseInt(o[vKey]);}
				);
			}
			return vTotal;
		};
		self.sumByFloat = function(vArray,vKey, vDeepObject, vLedgerProjTotal){
			if(vDeepObject === true){
				vArray = _.flatten(_.values(vArray));
			}

			if(vLedgerProjTotal){
				var vTempArray = [];
				$.each(vArray, function(i,v){
					vTempArray.push(_.flatten(_.values(v)));
				});
				vArray = _.flatten(vTempArray);
			}

			var vTotal = 0 ;
			if(vArray){
				vTotal = _.sumBy(vArray, function(o){
						return parseFloat(o[vKey]);}
				);
			}
			return vTotal;
		};
		self.getTotal = function(vType){
			var vTotalArray = _.flatten(_.flatten(_.values(_.map(self.PartiesData,function(v){return _.values(v);}))));
			if(self.recentsearch.searchBy == 7 || self.recentsearch.searchBy == 8){
				vTotalArray =_.flatten(_.flatten(_.map(vTotalArray, _.values)));
			}
			switch(vType){
				case "TPC":

					var vTotal = 0 ;
					if(self.PartiesData){
						
						
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseInt(o.PayTotalCnt);}
						);
					}
					return vTotal;
				break;
				case "TP":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseFloat(o.PayTotal);}
						);
					}
					return vTotal.toFixed(2);
				break;
				case "TRC":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseInt(o.RecptTotalCnt);}
						);
					}
					return vTotal;
				break;
				case "TR":
					var vTotal = 0.0 ;
					if(self.PartiesData){
						vTotal = _.sumBy(vTotalArray, function(o){
								return parseFloat(o.RecptTotal);}
						);
					}
					return vTotal.toFixed(2);
				break;
			}
		};
		self.showTrnxs = function(vParty,vType,vDebitCredit, vProjectID){
			DetailsDataProv.clear();
			if(self.recentsearch.searchBy == 7 && !vProjectID)
				vParty = vParty[0];
			if(self.recentsearch.searchBy == 8) 
				vParty = vParty[0];
			if(vProjectID)DetailsDataProv.setParam("project_id",vProjectID);
			if(vParty.bank_account_id)DetailsDataProv.setParam("bank_account_id",vParty.bank_account_id);
			if(vParty.bank_id)DetailsDataProv.setParam("bank",vParty.bank_id);
			if(vParty.account_name)DetailsDataProv.setParam("account_name",vParty.account_name);
			if(vParty.account_number)DetailsDataProv.setParam("account_number",vParty.account_number);
			if(vParty.ledger_reference_table)DetailsDataProv.setParam("ledger_reference_table",vParty.ledger_reference_table);
			if(vDebitCredit)DetailsDataProv.setParam("TrnxType",vDebitCredit);
			if(vType)DetailsDataProv.setParam("ClearanceStatus",vType);
			if(vParty.sSearchBy){
				DetailsDataProv.setParam("searchBy",vParty.sSearchBy);
				DetailsDataProv.setParam("searchID",vParty.sSearchID);
			}
			else if(self.recentsearch.searchBy){
				DetailsDataProv.setParam("searchBy",self.recentsearch.searchBy);
				DetailsDataProv.setParam("searchID",self.recentsearch.searchID);
			}
			if(vParty.sStartDate)
				DetailsDataProv.setParam("FromDate",vParty.sStartDate);
			else if(self.recentsearch.startDate)
				DetailsDataProv.setParam("FromDate",self.self.recentsearch.startDate);
			if(vParty.sEndDate)
				DetailsDataProv.setParam("ToDate",vParty.sEndDate);
			else if(self.recentsearch.endDate)
				DetailsDataProv.setParam("ToDate",self.recentsearch.endDate);
			$location.path("/LedgerDetails");
		};
		self.getSize = function(vIn){
			return  (Object.keys(vIn).length*2) + _.chain(vIn).values().flatten().value().length;
		}
		if("<?=$bank_account_id?>")	DetailsDataProv.setParam("bank_account_id","<?=$bank_account_id?>");
		if("<?=$bank?>")			DetailsDataProv.setParam("bank","<?=$bank?>");
		if("<?=$account_name?>")	DetailsDataProv.setParam("account_name","<?=$account_name?>");
		if("<?=$account_number?>")	DetailsDataProv.setParam("account_number","<?=$account_number?>");
		if("<?=$ledger_reference_table?>")	DetailsDataProv.setParam("ledger_reference_table","<?=$ledger_reference_table?>");
		if("<?=$TrnxType?>")		DetailsDataProv.setParam("TrnxType","<?=$TrnxType?>");
		if("<?=$ClearanceStatus?>")	DetailsDataProv.setParam("ClearanceStatus","<?=$ClearanceStatus?>");
		if("<?=$PartyID?>")			DetailsDataProv.setParam("PartyID","<?=$PartyID?>");
		if("<?=$PartyName?>")		DetailsDataProv.setParam("PartyName","<?=$PartyName?>");
		if("<?=$FromDate?>")		DetailsDataProv.setParam("FromDate","<?=$FromDate?>");
		if("<?=$ToDate?>")			DetailsDataProv.setParam("ToDate","<?=$ToDate?>");
		
		if("<?=$searchBy?>")			DetailsDataProv.setParam("searchBy","<?=$searchBy?>");
		if("<?=$searchID?>")			DetailsDataProv.setParam("searchID","<?=$searchID?>");
		
		if("<?=$project_id?>")			DetailsDataProv.setParam("project_id","<?=$project_id?>");
		
	}])
	.factory('DateFormater',[function(){
		return {
			convertDtToJSDate : function(vStringDate){
				if(vStringDate && vStringDate != "0000-00-00 00:00:00" && vStringDate.split('-').length > 2){
					var vTDate = Date.parse(vStringDate);
					return new Date(vTDate);
					var vSplitDate = vStringDate.split(' ');
					var vDatePart = vSplitDate[0].split('-');
					vTDate.setFullYear(vDatePart[0]);
					vTDate.setMonth(parseInt(vDatePart[1])-1);
					vTDate.setDate(vDatePart[2]);

					var vTimePart = vSplitDate[1].split(':');
					vTDate.setHours(vTimePart[0]);
					vTDate.setMinutes(vTimePart[1]);
					vTDate.setSeconds(0);
					vTDate.setMilliseconds(0);
					return  vTDate;
				}else{
					return "";
				}
			},
			convertToJSDate : function(vStringDate){
				if(vStringDate && vStringDate != "0000-00-00" && vStringDate.split('-').length > 2){
					var vTDate = Date.parse(vStringDate);
					return new Date(vTDate);
					var vSplitDate = vStringDate.split('-');
					vTDate.setFullYear(vSplitDate[0]);
					vTDate.setMonth(parseInt(vSplitDate[1])-1);
					vTDate.setDate(vSplitDate[2]);
					return vTDate;
				}else{
					return "";
				}
			},
			convertJsDate : function(vDate){
				if(vDate) return  vDate.getFullYear()+"-"+ ("0" + (vDate.getMonth()+1)).slice(-2) +"-"+ ("0" + vDate.getDate()).slice(-2);
				else return "";
			},
			convertJsDateTime : function(vDate){
				if(vDate) return  vDate.getFullYear()+"-"+ ("0" + (vDate.getMonth()+1)).slice(-2) +"-"+ ("0" + vDate.getDate()).slice(-2) + " " + vDate.getHours() + ":"+vDate.getMinutes();
				else return "";
			}
		};
	}])
	.factory('DetailsDataProv',[function(){
		var vHiddenData = {};
		return {
			setParam : function(vParam,vValue){
				vHiddenData[vParam] = vValue;
			},
			getParam : function(vParam,vDefault){
				if(vHiddenData[vParam])
					return vHiddenData[vParam];
				else
					return vDefault;
			},
			clear : function(){
				vHiddenData = {};
			},
			getAllData : function(){
				return vHiddenData;
			}
		};
	}])
	.factory('XHRCountsProv',[function(){
		var vActiveXhrCount = 0;
		return {
			newCall : function(){
				vActiveXhrCount++;
			},
			endCall : function(){
				vActiveXhrCount--;
			},
			getActiveXhrCount : function(){
				return vActiveXhrCount;
			}
		};
	}])
	.factory('HttpInterceptor',['$q','XHRCountsProv',function($q,XHRCountsProv){
		return {
			request : function(config){
				XHRCountsProv.newCall();
				$(".BusyLoopMain").removeClass("BusyLoopHide").addClass("BusyLoopShow");
				return config;
			},
			requestError: function(rejection){
				XHRCountsProv.endCall();
				if(XHRCountsProv.getActiveXhrCount() == 0)
					$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
				return $q.reject(rejection);
			},
			response:function(response){
				XHRCountsProv.endCall();
				if(XHRCountsProv.getActiveXhrCount() == 0)
					$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
				return response;
			},
			responseError:function(rejection){
				XHRCountsProv.endCall();
				if(XHRCountsProv.getActiveXhrCount() == 0)
					$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
				return $q.reject(rejection);
			}

		};
	}])
	.filter('mapYesNo',[function(){
		return function(vNum){
			if(vNum == "1") return "Yes";
			else if(vNum == "0") return "No";
			else return "";
		}
	}])
	
	.controller('LedgerDetailsCtrl',['DetailsDataProv','tranxData','DateFormater',function(DetailsDataProv,tranxData,DateFormater){
		// DetailsDataProv
		var self = this;
		self.bank_books = tranxData;
		self.searchByName = $("#SearchBy option[value='"+DetailsDataProv.getParam("searchBy")+"']").text();
		var vSearchBy = DetailsDataProv.getParam("searchBy");
		if(vSearchBy == "1" || vSearchBy == "7" || vSearchBy == "8")
			self.searchIDName=$("#LedgerAcntID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "2")
			self.searchIDName=$("#LedgerSubAcntID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "3" || vSearchBy == "6")
			self.searchIDName=$("#PartyName option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "4")
			self.searchIDName=$("#ItemID option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		else if(vSearchBy == "5")
			self.searchIDName=$("#ProjectName option[value='string:"+DetailsDataProv.getParam("searchID")+"']").text();
		
		
		self.account_name = DetailsDataProv.getParam("account_name");
		self.account_number = DetailsDataProv.getParam("account_number");

		self.AttachFiles = function(vBook){
			var vNewForm = "<form method='post' action='/funds_tracker/upload' id='form_"+vBook.transaction_id+"' style='display:none;'>";
			vNewForm += '<input type="hidden" name="bank_account_id" value="'+DetailsDataProv.getParam("bank_account_id","")+'" />';
			vNewForm += '<input type="hidden" name="bank" value="'+DetailsDataProv.getParam("bank","")+'" />';
			vNewForm += '<input type="hidden" name="searchBy" value="'+DetailsDataProv.getParam("searchBy","")+'" />';
			vNewForm += '<input type="hidden" name="searchID" value="'+DetailsDataProv.getParam("searchID","")+'" />';
			vNewForm += '<input type="hidden" name="account_name" value="'+DetailsDataProv.getParam("account_name","")+'" />';
			vNewForm += '<input type="hidden" name="account_number" value="'+DetailsDataProv.getParam("account_number","")+'" />';
			vNewForm += '<input type="hidden" name="ledger_reference_table" value="'+DetailsDataProv.getParam("ledger_reference_table","")+'" />';
			vNewForm += '<input type="hidden" name="ClearanceStatus" value="'+DetailsDataProv.getParam("ClearanceStatus","")+'" />';
			vNewForm += '<input type="hidden" name="TrnxType" value="'+DetailsDataProv.getParam("TrnxType","")+'" />';
			vNewForm += '<input type="hidden" name="StartDate" value="'+DetailsDataProv.getParam("FromDate","")+'" />';
			vNewForm += '<input type="hidden" name="Date" value="'+vBook.date+'" />';
			vNewForm += '<input type="hidden" name="PartyName" value="'+(vBook.party_name == null ? "" :vBook.party_name) +'" />';
			vNewForm += '<input type="hidden" name="Narration" value="'+vBook.narration+'" />';
			vNewForm += '<input type="hidden" name="IType" value="'+(vBook.instrument_type || "")+'" />';
			vNewForm += '<input type="hidden" name="IID" value="'+vBook.instrument_id_manual+'" />';
			vNewForm += '<input type="hidden" name="IDate" value="'+(vBook.instrument_date || "")+'" />';
			vNewForm += '<input type="hidden" name="BName" value="'+(vBook.bank_name || "")+'" />';
			vNewForm += '<input type="hidden" name="TType" value="'+vBook.debit_credit+'" />';
			vNewForm += '<input type="hidden" name="TAmt" value="'+vBook.transaction_amount+'" />';
			vNewForm += '<input type="hidden" name="BCS" value="'+(vBook.clearance_status == 1 ? "Yes" : "No")+'" />';
			vNewForm += '<input type="hidden" name="CD" value="'+(vBook.TrnxClearance_date||"")+'" />';
			vNewForm += '<input type="hidden" name="BR" value="'+(vBook.bill_recieved == 1 ? "Yes" : "No")+'" />';
			vNewForm += '<input type="hidden" name="Notes" value="'+vBook.notes+'" />';
			vNewForm += '<input type="hidden" name="Module" value="LedgerReport" />';
			vNewForm += '<input type="hidden" name="EndDate" value="'+DetailsDataProv.getParam("ToDate","")+'" />';
			vNewForm += '<input type="hidden" name="TranxID" value="'+vBook.transaction_id+'" />';
			vNewForm += '<input type="hidden" name="ledgerType" value="'+vBook.ledgerType+'" />';
			vNewForm += '<input type="hidden" name="PaymentVoucherNumber" value="'+vBook.bank_annual_voucher_id+'" />';
			vNewForm += "</form>";
			$("body").append(vNewForm);
			$("#form_"+vBook.transaction_id).submit();
		};
	}])
	.config(['$httpProvider','$routeProvider',function($httpProvider,$routeProvider){
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
		$httpProvider.defaults.transformRequest.push(function(data){
			if(data){
				return $.param(JSON.parse(data));
			}else 
				return "";
		});
		$httpProvider.interceptors.push('HttpInterceptor');

		$routeProvider.when('/LedgerDetails', {
			templateUrl: '<?php echo base_url(); ?>index.php/report/ledgerdetailspage' ,
			resolve : {
				tranxData : ['DetailsDataProv','$http','$location',function(DetailsDataProv,$http,$location){
					if(DetailsDataProv.getAllData() && Object.keys(DetailsDataProv.getAllData()).length > 0){
						return $http.post('<?php echo base_url(); ?>index.php/report/getLedgerDetailsData',DetailsDataProv.getAllData()).then(
							function(response) {
								return response.data;                  
							}
						);
					}
					else {
						$location.path('');
						return false;
					}
				}]
			},
			controller : 'LedgerDetailsCtrl as PDetails'
		});
	}])
	.filter('abs', function () {
		return function(val) {
		  return Math.abs(val);
		}
	});
	function formatDate(date) {
		var d = new Date(date);
		var year = d.getFullYear();
		var month = (d.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based, so we add 1
		var day = d.getDate().toString().padStart(2, '0');
		return year + '-' + month + '-' + day;
	}

</script>