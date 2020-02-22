//
//  MainTableViewController.swift
//  assignment02_A00426401
//
//  Created by jiye wang on 2019-07-26.
//  Copyright © 2019 jiye wang. All rights reserved.
//

import UIKit

class MainTableViewController: UITableViewController {

    @IBOutlet var tableVIew: UITableView!
    var wonders:[Wonders] = []
    var imageNames: [String] = []
    override func viewDidLoad() {
        super.viewDidLoad()
        loadJsonFile()
        imageNames = ["pyramids", "statue", "flowers", "lighthouse", "tomb", "statue", "temple","temple"]
        // Uncomment the following line to preserve selection between presentations
        // self.clearsSelectionOnViewWillAppear = false

        // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
        // self.navigationItem.rightBarButtonItem = self.editButtonItem
    }

    func loadJsonFile() {
        guard let jsonFile = Bundle.main.path(forResource: "wonders", ofType: "json") else { return }
        let optionalData = try? Data(contentsOf: URL(fileURLWithPath: jsonFile))
        guard
            let data = optionalData,
            let json = try? JSONSerialization.jsonObject(with: data),
            let dictionary = json as? [String: Any],
            let wondersDictionary = dictionary["features"] as? [[String: Any]]
            else { return }
        let validWonders = wondersDictionary.compactMap { Wonders(wonder: $0) }
        wonders.append(contentsOf: validWonders)
    }
    
    // MARK: - Table view data source

    override func numberOfSections(in tableView: UITableView) -> Int {
        // #warning Incomplete implementation, return the number of sections
        return 1
    }

    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete implementation, return the number of rows
        return wonders.count
    }
    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "resultTableView", for: indexPath) as? MainTableViewCell else {return UITableViewCell()}
        //        if indexPath.item % 2 == 0{
        //            cell.backgroundColor = UIColor.gray
        //        }else{
        //            cell.backgroundColor = UIColor.darkGray
        //        }
        // Configure the cell...
        cell.Label01.text = wonders[indexPath.row].name
        cell.icon.image = UIImage(named: imageNames[indexPath.row])
        return cell
    }
    
    override func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 150
    }
    
    override func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let vc = storyboard?.instantiateViewController(withIdentifier: "WondersDetailViewController") as? WondersDetailViewController
//        vc?.image = UIImage(named: imageNames[indexPath.row])!
        vc?.name = wonders[indexPath.row].name
        vc?.descrip = "Description: " + String(wonders[indexPath.row].description ?? "None")
        vc?.userR = "User Rating: " + String(wonders[indexPath.row].userRating)
        vc?.imgstring = wonders[indexPath.row].imageURL
        self.navigationController?.pushViewController(vc!, animated: true)
    }
}


